<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class PhotoUploadService
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new GdDriver());
    }

    /**
     * Simpan satu file foto ke disk.
     *
     * Opsi yang didukung:
     * - disk (string, default 'public')
     * - compress (bool, default false)
     * - compress_threshold_kb (int, default 300) - kompresi hanya jalan jika file lebih besar dari ini
     * - compress_steps (array<array{width:int,quality:int}>, default [[1200,70],[800,65]])
     *   Setiap step dicoba berurutan sampai ukuran file <= threshold.
     *
     * @return string path hasil penyimpanan (relatif terhadap disk)
     */
    public function store(UploadedFile $file, string $folder, array $options = []): string
    {
        $disk = $options['disk'] ?? 'public';
        $path = $file->store($folder, $disk);

        if ($options['compress'] ?? false) {
            $this->compress($path, $disk, $options);
        }

        return $path;
    }

    /**
     * Simpan banyak file sekaligus dengan opsi yang sama.
     *
     * @param  UploadedFile[]  $files
     * @return string[] path hasil penyimpanan, urutan sama dengan $files
     */
    public function storeMany(array $files, string $folder, array $options = []): array
    {
        return array_map(fn (UploadedFile $file) => $this->store($file, $folder, $options), $files);
    }

    public function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($path);
    }

    /**
     * @param  string[]  $paths
     */
    public function deleteMany(array $paths, string $disk = 'public'): void
    {
        if (! empty($paths)) {
            Storage::disk($disk)->delete($paths);
        }
    }

    protected function compress(string $path, string $disk, array $options): void
    {
        $storage = Storage::disk($disk);
        $thresholdBytes = ($options['compress_threshold_kb'] ?? 300) * 1024;

        if ($storage->size($path) <= $thresholdBytes) {
            return;
        }

        $image = $this->imageManager->read($storage->get($path));

        $this->applyCompressionSteps(
            $image,
            $options['compress_steps'] ?? null,
            $thresholdBytes,
            fn (string $bytes) => $storage->put($path, $bytes),
            fn () => $storage->size($path),
        );
    }

    /**
     * Kompres file upload di tempatnya (menimpa file sementara PHP), tanpa
     * menyimpannya ke disk Laravel - dipakai sebelum file diserahkan ke
     * penyimpanan lain (mis. Spatie MediaLibrary) yang mengelola disk sendiri.
     *
     * Opsi yang didukung sama seperti store(): compress_threshold_kb, compress_steps.
     */
    public function compressInPlace(UploadedFile $file, array $options = []): bool
    {
        $thresholdBytes = ($options['compress_threshold_kb'] ?? 300) * 1024;
        $realPath = $file->getRealPath();

        if (filesize($realPath) <= $thresholdBytes) {
            return false;
        }

        $image = $this->imageManager->read($realPath);

        $this->applyCompressionSteps(
            $image,
            $options['compress_steps'] ?? null,
            $thresholdBytes,
            fn (string $bytes) => file_put_contents($realPath, $bytes),
            fn () => filesize($realPath),
        );

        return true;
    }

    /**
     * @param  array<array{width:int,quality:int}>|null  $steps
     */
    protected function applyCompressionSteps(
        \Intervention\Image\Interfaces\ImageInterface $image,
        ?array $steps,
        int $thresholdBytes,
        callable $write,
        callable $currentSize,
    ): void {
        $steps ??= [
            ['width' => 1200, 'quality' => 70],
            ['width' => 800, 'quality' => 65],
        ];

        foreach ($steps as $step) {
            $image->scaleDown(width: $step['width']);
            $write((string) $image->toJpeg(quality: $step['quality']));

            if ($currentSize() <= $thresholdBytes) {
                break;
            }
        }
    }
}
