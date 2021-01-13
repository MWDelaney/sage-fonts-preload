<?php
use Illuminate\Support\Str;

use function Roots\asset;

if (! function_exists('add_filter')) {
    return;
}

add_filter('wp_head', function () {
    echo collect(
        json_decode(file_get_contents(asset('mix-manifest.json')))
    )->keys()->filter(function ($item) {
        return Str::endsWith($item, ['.otf', '.eot', 'woff', 'woff2', 'ttf']);
    })->map(function ($item) {
        return sprintf('<link rel="preload" href="%s%s" as="font" crossorigin>', get_stylesheet_directory_uri() . '/dist', $item);
    })->implode("\n");
});
