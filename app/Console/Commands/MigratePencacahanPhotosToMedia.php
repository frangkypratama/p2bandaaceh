<?php

namespace App\Console\Commands;

use App\Models\PencacahanSbp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigratePencacahanPhotosToMedia extends Command
{
    protected $signature = 'pencacahan:migrate-photos-to-media {--dry-run : Tampilkan yang akan dilakukan tanpa mengubah data}';

    protected $description = 'Migrasikan foto Pencacahan lama (tabel pencacahan_photos) ke Spatie MediaLibrary (tabel media)';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        // File lama sudah dipindah ke disk 'local' (private) - lihat catatan deploy.
        $disk = Storage::disk('local');

        $pencacahanSbps = PencacahanSbp::with(['legacyPhotos', 'media'])->has('legacyPhotos')->get();

        if ($pencacahanSbps->isEmpty()) {
            $this->info('Tidak ada foto pencacahan lama yang perlu dimigrasikan.');

            return self::SUCCESS;
        }

        $migrated = 0;
        $skipped = 0;

        foreach ($pencacahanSbps as $pencacahanSbp) {
            // Collection 'foto' bersifat singleFile - kalau ternyata ada >1 foto lama
            // untuk satu pencacahan_sbp (anomali data), ambil yang paling baru saja,
            // sisanya dilewati (bukan hilang, tetap ada di tabel lama sebagai cadangan).
            $legacyPhoto = $pencacahanSbp->legacyPhotos->sortByDesc('id')->first();
            $extraCount = $pencacahanSbp->legacyPhotos->count() - 1;

            if ($extraCount > 0) {
                $this->warn("PencacahanSbp #{$pencacahanSbp->id}: ditemukan {$pencacahanSbp->legacyPhotos->count()} foto lama, hanya yang terbaru (id {$legacyPhoto->id}) yang dimigrasikan.");
            }

            $alreadyMigrated = $pencacahanSbp->getMedia('foto')
                ->contains(fn ($media) => $media->getCustomProperty('legacy_pencacahan_photo_id') === $legacyPhoto->id);

            if ($alreadyMigrated) {
                $skipped++;

                continue;
            }

            if (! $disk->exists($legacyPhoto->path)) {
                $this->warn("PencacahanSbp #{$pencacahanSbp->id}: file hilang di disk - {$legacyPhoto->path} (pencacahan_photos id {$legacyPhoto->id}), dilewati.");
                $skipped++;

                continue;
            }

            if ($dryRun) {
                $this->line("[DRY-RUN] Akan migrasikan PencacahanSbp #{$pencacahanSbp->id}: {$legacyPhoto->path}");
                $migrated++;

                continue;
            }

            $pencacahanSbp->addMedia($disk->path($legacyPhoto->path))
                ->preservingOriginal()
                ->withCustomProperties(['legacy_pencacahan_photo_id' => $legacyPhoto->id])
                ->usingFileName(basename($legacyPhoto->path))
                ->toMediaCollection('foto');

            $migrated++;
        }

        $prefix = $dryRun ? '[DRY-RUN] ' : '';
        $this->info("{$prefix}Selesai. Berhasil: {$migrated}, dilewati: {$skipped}.");

        return self::SUCCESS;
    }
}
