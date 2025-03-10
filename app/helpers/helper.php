<?php

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

function  neeraj()
{
    return "working helper funciton";
}

function createThumbnail($image, $thumbWidth = 150, $thumbHeight = 150)

{
    $originalPath = $image->store('images', 'public'); // Save original image in storage/app/public/images
    $thumbnailPath = 'images/thumbs/' . basename($originalPath);
    $sourcePath = storage_path('app/public/' . $originalPath);
    $destinationPath = storage_path('app/public/' . $thumbnailPath);
    // Ensure the directory for thumbnails exists
    $directory = dirname($destinationPath);
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true); // Create the directory if it doesn't exist
    }

    // Get image type and create image resource accordingly
    $imageInfo = getimagesize($sourcePath);
    $imageType = $imageInfo[2];

    // Load the image based on type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($sourcePath);
            break;
        default:
            throw new \Exception('Unsupported image type.');
    }

    // Get original dimensions
    list($width, $height) = getimagesize($sourcePath);

    // Calculate aspect ratio and resize dimensions
    $aspectRatio = $width / $height;
    if ($thumbWidth / $thumbHeight > $aspectRatio) {
        $thumbWidth = $thumbHeight * $aspectRatio;
    } else {
        $thumbHeight = $thumbWidth / $aspectRatio;
    }

    // Create a blank image for the thumbnail
    $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);

    // Copy and resize the original image into the thumbnail
    imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    // Save the thumbnail based on the original image type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbnail, $destinationPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbnail, $destinationPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumbnail, $destinationPath);
            break;
    }

    // Free up memory
    imagedestroy($image);
    imagedestroy($thumbnail);

    return [$originalPath, $thumbnailPath];
}

function deleteImage($model)
{
    if ($model->image) {
        Storage::delete($model->image);
    }
    if ($model->thumb_image) {
        Storage::delete($model->thumb_image);
    }
}
