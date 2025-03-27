<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\InteractsWithMedia;
// use Spatie\Image\Enums\Fit;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait ImageCollectionMedia
{
    use InteractsWithMedia;

    /**
     * append custom property image to model when model is initializing
     */
    protected function initializeImageCollectionMedia()
    {
        $this->appends = ['image'];
    }

    /**
     * makes laravel aware of custom initialize method
     */
    protected static function bootImageCollectionMedia()
    {
        $class = static::class;
        $method = "initializeImageCollectionMedia";

        static::$traitInitializers[$class][] = $method;

        static::$traitInitializers[$class] = array_unique(
            static::$traitInitializers[$class]
        );
    }


    /**
     * create a custom image property with image url from medialibrary as value
     */
    protected function image(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getFirstMediaUrl('image'),
        );
    }

    /**
     * register laravel-medialibrary collection to hold only single file
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();

        // $this
        //     ->addMediaCollection('preview')
        //     ->singleFile();
    }

    /**
     * automatically generate thumbnail for uploaded image.
     *
     * usage : $yourModel->getFirstMediaUrl('image', 'preview');
     */
    // public function registerMediaConversions(?Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('preview')
    //         ->fit(Fit::Contain, 300, 300)
    //         ->nonQueued();
    // }
}
