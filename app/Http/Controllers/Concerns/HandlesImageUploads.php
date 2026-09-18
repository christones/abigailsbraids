<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;

trait HandlesImageUploads
{
    /**
     * Move an uploaded image into public/uploads/{folder} and return its
     * path relative to the public directory (e.g. "uploads/services/xxx.jpg").
     *
     * Files are stored directly under the public web root -- rather than
     * Laravel's storage/app/public disk -- so they work without needing a
     * "storage" symlink, which isn't reliably creatable on shared hosting
     * without shell access.
     */
    protected function storeUploadedImage(UploadedFile $file, string $folder): string
    {
        $filename = $file->hashName();
        $file->move(public_path("uploads/{$folder}"), $filename);

        return "uploads/{$folder}/{$filename}";
    }

    /**
     * Delete a previously uploaded image file, if it lives under
     * public/uploads (never deletes the seeded public/images assets).
     */
    protected function deleteUploadedImage(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/')) {
            return;
        }

        $fullPath = public_path($path);

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
