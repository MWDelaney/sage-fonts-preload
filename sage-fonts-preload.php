<?php
use Illuminate\Support\Str;

use function Roots\asset;

if (! function_exists('add_filter')) {
    return;
}

if (! file_exists(asset('mix-manifest.json'))) {
    return;
}

add_filter('wp_head', function () {
    // Set an array of font types
    $types = ['.otf', '.eot', 'woff', 'woff2', 'ttf'];

    // Get the mix manifest contents
    $json = json_decode(file_get_contents(asset('mix-manifest.json')));

    // Echo link tags for each font
    echo collect(
        $json
    )->keys()->filter(function ($item) {
        return Str::endsWith($item, $types);
    })->map(function ($item) {
        return sprintf('<link rel="preload" href="%s%s" as="font" crossorigin>', get_stylesheet_directory_uri() . '/dist', $item);
    })->implode("\n");
});
