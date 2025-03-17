<?php

namespace App\Helpers;

class ImageUploadHelper
{
    public static function uploadImage($file, $directory)
    {
        $uploadPath = public_path("images/{$directory}");

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $fileName);

        return "/images/{$directory}/{$fileName}";
    }
}
