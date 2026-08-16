<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MovePencacahanPhotosToPrivate extends Command
{
    protected $signature = 'pencacahan:move-photos-to-private {--dry-run : Tampilkan yang akan dipindah tanpa mengubah data}';

    protected $description = 'Pindahkan file foto pencacahan lama dari disk public ke disk local (privat). Jalankan ini SEBELUM pencacahan:migrate-photos-to-media.';

    private const FOLDER = 'pencacahan_photos';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $publicDisk = Storage::disk('public');
        $localDisk = Storage::disk('local');

        if (! $publicDisk->exists(self::FOLDER)) {
            $this->info('Folder "'.self::FOLDER.'" tidak ada di disk public - kemungkinan sudah dipindah sebelumnya, atau memang belum pernah ada.');

            return self::SUCCESS;
        }

        $files = $publicDisk->files(self::FOLDER);

        if (empty($files)) {
            $this->info('Folder "'.self::FOLDER.'" ada tapi kosong, tidak ada yang perlu dipindah.');

            return self::SUCCESS;
        }

        $moved = 0;
        $alreadyPresent = 0;

        foreach ($files as $file) {
            $existsInPrivate = $localDisk->exists($file);

            // File tetap dihapus dari disk public di kedua kasus (sudah ada di
            // private atau belum) - tujuannya menutup akses publik ke file ini,
            // bukan sekadar menyalin.
            if ($dryRun) {
                $action = $existsInPrivate
                    ? 'sudah ada di private, akan dihapus saja dari public'
                    : 'akan disalin ke private lalu dihapus dari public';
                $this->line("[DRY-RUN] {$file}: {$action}");
                $existsInPrivate ? $alreadyPresent++ : $moved++;

                continue;
            }

            if (! $existsInPrivate) {
                $localDisk->put($file, $publicDisk->get($file));
                $moved++;
            } else {
                $alreadyPresent++;
            }

            $publicDisk->delete($file);
        }

        $prefix = $dryRun ? '[DRY-RUN] ' : '';
        $this->info("{$prefix}Selesai. Dipindah: {$moved}, sudah ada sebelumnya (tetap dibersihkan dari public): {$alreadyPresent}.");

        if (! $dryRun && empty($publicDisk->files(self::FOLDER))) {
            $publicDisk->deleteDirectory(self::FOLDER);
            $this->info('Folder "'.self::FOLDER.'" di disk public sudah kosong dan dihapus.');
        }

        return self::SUCCESS;
    }
}
