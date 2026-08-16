<?php

namespace App\Console\Commands;

use App\Models\Lpt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateLptPhotosToMedia extends Command
{
    protected $signature = 'lpt:migrate-photos-to-media {--dry-run : Tampilkan yang akan dilakukan tanpa mengubah data}';

    protected $description = 'Migrasikan foto LPT lama (tabel lpt_photos) ke Spatie MediaLibrary (tabel media)';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $disk = Storage::disk('local');

        $lpts = Lpt::with('legacyPhotos', 'media')->has('legacyPhotos')->get();

        if ($lpts->isEmpty()) {
            $this->info('Tidak ada LPT dengan foto lama yang perlu dimigrasikan.');

            return self::SUCCESS;
        }

        $migrated = 0;
        $skipped = 0;

        foreach ($lpts as $lpt) {
            foreach ($lpt->legacyPhotos as $legacyPhoto) {
                $alreadyMigrated = $lpt->getMedia('photos')
                    ->contains(fn ($media) => $media->getCustomProperty('legacy_lpt_photo_id') === $legacyPhoto->id);

                if ($alreadyMigrated) {
                    $skipped++;

                    continue;
                }

                if (! $disk->exists($legacyPhoto->file_path)) {
                    $this->warn("LPT #{$lpt->id}: file hilang di disk - {$legacyPhoto->file_path} (lpt_photos id {$legacyPhoto->id}), dilewati.");
                    $skipped++;

                    continue;
                }

                if ($dryRun) {
                    $this->line("[DRY-RUN] Akan migrasikan LPT #{$lpt->id}: {$legacyPhoto->file_path}");
                    $migrated++;

                    continue;
                }

                $lpt->addMedia($disk->path($legacyPhoto->file_path))
                    ->preservingOriginal()
                    ->withCustomProperties(['legacy_lpt_photo_id' => $legacyPhoto->id])
                    ->usingFileName(basename($legacyPhoto->file_path))
                    ->toMediaCollection('photos');

                $migrated++;
            }
        }

        $prefix = $dryRun ? '[DRY-RUN] ' : '';
        $this->info("{$prefix}Selesai. Berhasil: {$migrated}, dilewati: {$skipped}.");

        return self::SUCCESS;
    }
}
