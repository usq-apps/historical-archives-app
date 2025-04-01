<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HistoricalItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    protected $casts = [
        'item_date_from' => 'datetime:d/m/Y',
        'item_date_to' => 'datetime:d/m/Y',
    ];

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class)->withTimestamps();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections('documents')
            ->pdfPageNumber(1)
            ->fit(Manipulations::FIT_FILL_MAX, 400, 400)
            ->watermark(storage_path('media-overlays/document-overlay.png'))
            ->watermarkPosition(Manipulations::POSITION_CENTER);

        $this->addMediaConversion('thumb')
            ->performOnCollections('images')
            ->fit(Manipulations::FIT_CROP, 400, 400)
            ->watermark(storage_path('media-overlays/image-overlay.png'))
            ->watermarkPosition(Manipulations::POSITION_CENTER);

        $this->addMediaConversion('thumb')
            ->performOnCollections('videos')
            ->extractVideoFrameAtSecond(6)
            ->fit(Manipulations::FIT_CROP, 400, 400)
            ->watermark(storage_path('media-overlays/video-overlay.png'))
            ->watermarkPosition(Manipulations::POSITION_CENTER);

        $this->addMediaConversion('thumb')
            ->performOnCollections('audio')
            ->fit(Manipulations::FIT_CROP, 400, 270);
    }
}
