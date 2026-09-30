<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait HasFileCleanup
{
    /**
     * Boot the trait to attach Eloquent model event listeners for automatic file cleanup.
     */
    protected static function bootHasFileCleanup(): void
    {
        // Event listener saat data diperbarui (Updating)
        static::updating(function ($model) {
            $fileAttributes = $model->getFileCleanupAttributes();
            foreach ($fileAttributes as $attribute) {
                if ($model->isDirty($attribute)) {
                    $oldPath = $model->getOriginal($attribute);
                    $newPath = $model->$attribute;

                    // Hapus file fisik lama jika berkas fisik telah diganti
                    if (!empty($oldPath) && $oldPath !== $newPath) {
                        static::deletePhysicalFile($oldPath);
                    }
                }
            }
        });

        // Event listener saat data dihapus (Deleting)
        static::deleting(function ($model) {
            $fileAttributes = $model->getFileCleanupAttributes();
            foreach ($fileAttributes as $attribute) {
                $path = $model->$attribute;
                if (!empty($path)) {
                    static::deletePhysicalFile($path);
                }
            }
        });
    }

    /**
     * Dapatkan daftar atribut/kolom berkas file dari model.
     * Dapat disesuaikan di Model via properti `$fileAttributes` atau `$fileCleanupAttributes`.
     */
    public function getFileCleanupAttributes(): array
    {
        if (property_exists($this, 'fileAttributes') && is_array($this->fileAttributes)) {
            return $this->fileAttributes;
        }

        if (property_exists($this, 'fileCleanupAttributes') && is_array($this->fileCleanupAttributes)) {
            return $this->fileCleanupAttributes;
        }

        // Tentukan kandidat nama kolom berkas secara otomatis
        $candidates = ['file_path', 'thumbnail', 'image_path', 'cover_image', 'logo', 'image', 'avatar'];
        $found = [];
        foreach ($candidates as $cand) {
            if (array_key_exists($cand, $this->attributes) || in_array($cand, $this->getFillable())) {
                $found[] = $cand;
            }
        }
        return array_unique($found);
    }

    /**
     * Helper method statis untuk menghapus berkas fisik dari storage disk secara aman.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public static function deletePhysicalFile(?string $path, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        // Jangan hapus jika berupa URL eksternal (HTTP / HTTPS)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return false;
        }

        // Jangan hapus jika berupa berkas default / preset bawaan aplikasi
        $defaultKeywords = [
            'default',
            'placeholder',
            'logo-prob',
            'sample',
            'assets/',
            'images/default'
        ];
        foreach ($defaultKeywords as $keyword) {
            if (Str::contains($path, $keyword)) {
                return false;
            }
        }

        try {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->delete($path);
            }
        } catch (Throwable $e) {
            logger()->warning("Gagal menghapus berkas fisik '{$path}': " . $e->getMessage());
        }

        return false;
    }
}
