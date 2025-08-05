<?php

namespace mar3y\ImageUpload\Traits;

use mar3y\ImageUpload\Helpers\ImageUploadHelper;
use ReflectionClass;

trait HasImage
{
    public static function bootHasImage()
    {
        $imageAttributes = static::$imageAttributes ?? [];

        static::saving(function ($model) use ($imageAttributes) {
            foreach ($imageAttributes as $attribute) {
                if (isset($model->getAttributes()[$attribute])) {
                    $value = $model->getAttributes()[$attribute];
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $directory = strtolower((new ReflectionClass($model))->getShortName());
                        $path = ImageUploadHelper::uploadImage($value, $directory);
                        $model->setAttribute($attribute, $path);
                    }
                }
            }
        });
    }

    public function __get($key)
    {
        if (in_array($key, static::$imageAttributes ?? [])) {
            $value = parent::__get($key);
            return $value ? url('storage/' . ltrim($value, '/')) : null;
        }
        return parent::__get($key);
    }

    public function toArray()
    {
        $array = parent::toArray();
        foreach (static::$imageAttributes ?? [] as $attribute) {
            if (array_key_exists($attribute, $array)) {
                $array[$attribute] = $this->$attribute;
            }
        }
        return $array;
    }
}