<?php

namespace App\ImageGenerators;

use Imagick;
use ImagickPixel;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Conversions\ImageGenerators\ImageGenerator;

class Audio extends ImageGenerator
{
    public function __construct(public readonly string $imagePath)
    {}

    public function convert(string $file, Conversion $conversion = null) : string
    {
        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.jpg';

        $image = new Imagick();
        $image->readImage($this->imagePath);
        $image->setBackgroundColor(new ImagickPixel('none'));
        $image->setImageFormat('jpg');

        file_put_contents($imageFile, $image);

        return $imageFile;
    }

    public function requirementsAreInstalled() : bool
    {
        return class_exists(\Imagick::class);
    }

    public function supportedExtensions() : Collection
    {
        return collect(
            [
                'aac',
                'aif',
                'aifc',
                'aiff',
                'flac',
                'm4a',
                'mp3',
                'mp4',
                'ogg',
                'wav',
                'wma',
            ]
        );
    }

    public function supportedMimeTypes() : Collection
    {
        return collect(
            [
                'audio/aac',
                'audio/flac',
                'audio/mp4',
                'audio/mpeg',
                'audio/mpeg3',
                'audio/ogg',
                'audio/vnd.wav',
                'audio/x-aiff',
                'audio/x-flac',
                'video/x-ms-asf',
            ]
        );
    }
}

