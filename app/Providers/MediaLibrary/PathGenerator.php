<?php

declare(strict_types=1);

namespace App\Providers\MediaLibrary;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;

final class PathGenerator implements BasePathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @param Media $media
     * @return string
     */
    public function getPath(Media $media): string
    {
        return md5(Str::random()) . '/';
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     *
     * @param Media $media
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return md5(Str::random()) . '/conversions/';
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     *
     * @param Media $media
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return md5(Str::random()) . '/responsive-images/';
    }
}
