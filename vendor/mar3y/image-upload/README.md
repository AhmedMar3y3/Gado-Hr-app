# Image Upload Package

A Laravel package for handling image uploads in your applications.

## Installation

You can install the package via composer:

```bash
composer require mar3y/image-upload
```

## Usage

### Using the HasImage Trait

To use the `HasImage` trait in your model, follow these steps:

1.  **Add the trait to your model class:**

    ```php
    use mar3y\ImageUpload\Traits\HasImage;

    class YourModel extends Model
    {
        use HasImage;

        protected static $imageAttributes = ['image'];
    }
    ```

2.  **Define the image attributes:**

    In your model class, define the `$imageAttributes` property as an array of attribute names that will store image paths. For example, if your model has an `image` attribute, you would set `protected static $imageAttributes = ['image'];`.

3.  **Upload an image:**

    When you save a model instance with an image attribute set to an `UploadedFile` instance, the trait will automatically upload the image and store the path in the attribute.

    ```php
    $model = new YourModel();
    $model->image = $request->file('image');
    $model->save();
    ```

4.  **Retrieve the image URL:**

    You can retrieve the full URL of the image using the attribute name.

    ```php
    $imageUrl = $model->image;
    ```

### Using the ImageUploadHelper

You can also use the `ImageUploadHelper` class directly:

```php
use mar3y\ImageUpload\Helpers\ImageUploadHelper;

$path = ImageUploadHelper::uploadImage($file, 'your-directory');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
