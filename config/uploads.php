<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Uploads storage path
    |--------------------------------------------------------------------------
    |
    | Admin-uploaded images (gallery, services, trainings, products, booking
    | photos) are written directly to the filesystem instead of Laravel's
    | storage disk, so they work without a "storage" symlink on shared
    | hosting.
    |
    | On a typical cPanel split deployment, the app code lives outside the
    | public web root (e.g. "abigailsbraids_appN/") while a sibling
    | "public_html/" folder is what's actually served. Laravel's
    | public_path() always resolves to the app's own "public/" folder,
    | which is NOT web-reachable in that layout. Set UPLOADS_PATH in .env
    | to the absolute path of the real web root's "uploads" folder (e.g.
    | "/home/<cpanel-user>/public_html/uploads") to fix that. Leave it
    | unset for local development or a non-split deployment, where
    | public_path('uploads') is already web-reachable.
    |
    */

    'path' => env('UPLOADS_PATH'),

];
