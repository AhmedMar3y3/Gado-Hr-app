<?php

namespace mar3y\ImageUpload\Helpers;

class ImageUploadHelper
{
    public static function uploadImage($file, $directory)
    {
        $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('images/' . $directory, $fileName, 'public');
        return $path;
    }
}