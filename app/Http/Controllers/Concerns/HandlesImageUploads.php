<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;

trait HandlesImageUploads
{
    /**
     * Move an uploaded image into the uploads folder and return its path
     * relative to the public web root (e.g. "uploads/services/xxx.jpg").
     *
     * Files are stored directly on disk -- rather than Laravel's
     * storage/app/public disk -- so they work without needing a "storage"
     * symlink, which isn't reliably creatable on shared hosting without
     * shell access. See config/uploads.php for why the base path is
     * configurable rather than always public_path().
     */
    protected function storeUploadedImage(UploadedFile $file, string $folder): string
    {
        $filename = $file->hashName();
        $file->move("{$this->uploadsBasePath()}/{$folder}", $filename);

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

        $fullPath = $this->uploadsBasePath().'/'.substr($path, strlen('uploads/'));

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * The absolute directory uploads are written into. Defaults to
     * public_path('uploads'), but can be pointed at a different web root
     * (e.g. a sibling public_html/uploads on a split cPanel deployment)
     * via the UPLOADS_PATH .env variable.
     */
    private function uploadsBasePath(): string
    {
        return rtrim(config('uploads.path') ?: public_path('uploads'), '/');
    }
}
