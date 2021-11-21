<?php
use Illuminate\Support\Str;

use function Roots\asset;

if (! function_exists('add_filter')) {
    return;
}

add_filter('wp_head', function () {
    echo collect(
        json_decode(asset('mix-manifest.json')->contents())
    )->keys()->filter(function ($item) {
        return Str::endsWith($item, ['.otf', '.eot', '.woff', '.woff2', '.ttf']);
    })->map(function ($item) {
        // Return asset uri without versioning query string
        return sprintf(
            '<link rel="preload" href="%s" type="font/%s" as="font" crossorigin>',
            substr(asset($item)->uri(), 0, strpos(asset($item)->uri(), '?id=')),
            pathinfo($item, PATHINFO_EXTENSION)
        );
    })->implode("\n");
});
