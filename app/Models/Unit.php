<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Unit extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $appends = ['photo', 'excel'];

    protected $hidden = ['media'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo');
        $this->addMediaCollection('excel');
    }

    public function getPhotoAttribute(): Collection
    {
        $images = collect();
        $this->getMedia('photo')
            ->each(function ($image) use ($images) {
                $images->push($image->getUrl());
            });
        return $images;
    }

    public function getExcelAttribute()
    {
        return $this->getMedia('excel')->first()->getUrl();
    }

}
