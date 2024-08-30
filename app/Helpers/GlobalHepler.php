<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('uploadImage')) {
    /**
     * Upload an image to storage and return the file path.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @param string $disk
     * @return string|null
     */
    function uploadImage($image, $folder = 'images', $disk = 'public')
    {
        if (!$image) {
            return null;
        }
        $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs($folder, $filename, $disk);
        dd($path);
        return $path ? Storage::disk($disk)->url($path) : null;
    }
}
?>
