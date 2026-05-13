<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ImageOptimizationService
{
    private array $config;

    public function __construct()
    {
        $this->config = [
            'thumbnail' => ['width' => 400, 'height' => 300],
            'medium' => ['width' => 800, 'height' => 600],
            'large' => ['width' => 1200, 'height' => 800],
            'og' => ['width' => 1200, 'height' => 630],
            'quality' => 85,
        ];
    }

    public function process(UploadedFile $file, string $path = 'uploads', string $filename = null): array
    {
        $filename = $filename ?? Str::uuid()->toString();
        $ext = 'webp';

        $originalName = $filename . '.' . $ext;
        $thumbnailName = $filename . '_thumb.' . $ext;
        $mediumName = $filename . '_md.' . $ext;
        $ogName = $filename . '_og.' . $ext;

        $image = Image::read($file->getRealPath());

        // Original optimized ( Large )
        $this->saveWebp(
            clone $image,
            $path . '/' . $originalName,
            $this->config['large']['width'],
            $this->config['large']['height']
        );

        // Thumbnail
        $this->saveWebp(
            clone $image,
            $path . '/' . $thumbnailName,
            $this->config['thumbnail']['width'],
            $this->config['thumbnail']['height'],
            true
        );

        // Medium
        $this->saveWebp(
            clone $image,
            $path . '/' . $mediumName,
            $this->config['medium']['width'],
            $this->config['medium']['height']
        );

        // OG Image
        $this->saveWebp(
            clone $image,
            $path . '/' . $ogName,
            $this->config['og']['width'],
            $this->config['og']['height']
        );

        return [
            'original' => $path . '/' . $originalName,
            'thumbnail' => $path . '/' . $thumbnailName,
            'medium' => $path . '/' . $mediumName,
            'og' => $path . '/' . $ogName,
            'filename' => $filename,
        ];
    }

    private function saveWebp($image, string $path, int $width, int $height, bool $crop = false): void
    {
        if ($crop) {
            $image = $image->cover($width, $height);
        } else {
            $image = $image->scaleDown($width, $height);
        }

        $encoded = $image->toWebp($this->config['quality']);
        Storage::disk('public')->put($path, (string) $encoded);
    }

    public function delete(string $path, string $filename): void
    {
        $extensions = ['', '_thumb', '_md', '_og'];
        foreach ($extensions as $ext) {
            Storage::disk('public')->delete($path . '/' . $filename . $ext . '.webp');
        }
    }
}
