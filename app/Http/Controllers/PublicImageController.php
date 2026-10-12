<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicImageController extends Controller
{
    /**
     * Serve a picture of the app's own public/images folder.
     *
     * On the cPanel split deployment the web root (public_html) is a copy of
     * the app's public/ folder, and new sub-folders of public_html/images are
     * not always copied over. Apache then forwards the missing file to
     * Laravel (see public/.htaccess), and this route serves it straight from
     * the application folder, so new pictures always show up.
     */
    public function image(string $path): BinaryFileResponse
    {
        return $this->serveFrom([base_path('public/images')], $path);
    }

    /**
     * Serve an admin-uploaded picture (products, gallery, services...) that
     * is missing from public_html/uploads.
     *
     * Depending on the version that was live when it was uploaded, a picture
     * may have been written to the configured UPLOADS_PATH, to the web root,
     * or to the "public/uploads" folder of an application folder
     * (abigailsbraids_appN), which is not reachable from the web. This looks
     * in all of those places.
     */
    public function upload(string $path): BinaryFileResponse
    {
        $roots = array_filter([
            config('uploads.path'),
            public_path('uploads'),
            base_path('public/uploads'),
        ]);

        // Upload folders of the other application versions next to this one.
        foreach (glob(dirname(base_path()).'/abigailsbraids_app*/public/uploads', GLOB_ONLYDIR) ?: [] as $dir) {
            $roots[] = $dir;
        }

        return $this->serveFrom(array_unique($roots), $path);
    }

    /**
     * Return the first existing picture named $path inside one of $roots.
     *
     * @param  list<string>  $roots
     */
    private function serveFrom(array $roots, string $path): BinaryFileResponse
    {
        abort_unless(preg_match('/\.(jpe?g|png|gif|webp|svg|avif)$/i', $path), 404);

        foreach ($roots as $root) {
            $root = realpath($root);

            if (! $root) {
                continue;
            }

            $file = realpath($root.DIRECTORY_SEPARATOR.$path);

            if ($file && str_starts_with($file, $root.DIRECTORY_SEPARATOR) && is_file($file)) {
                return response()->file($file, [
                    'Cache-Control' => 'public, max-age=604800',
                ]);
            }
        }

        abort(404);
    }
}
