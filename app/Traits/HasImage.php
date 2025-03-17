<?php

namespace App\Traits;

use ReflectionClass;
use App\Helpers\ImageUploadHelper;

trait HasImage
{

    public function setImageAttribute($value)
    {
        if ($value) {
            $directory = strtolower((new ReflectionClass($this))->getShortName());
            $this->attributes['image'] = ImageUploadHelper::uploadImage($value, $directory);
        }
    }

    public function getImageAttribute($value)
    {
        return $value ? rtrim(env('APP_URL'), '/') . $value : null;
    }
}
