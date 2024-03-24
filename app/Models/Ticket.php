<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    public const mapType = ['RECORDING' => 'Recording', 'REGULAR' => 'Regular', 'PRIORITY' => 'Priority'];

    public const mapStatus = ['RECORDING' => 'Recording', 'REGULAR' => 'Regular', 'PRIORITY' => 'Priority'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ticket_image');
    }

    public function getTicketImageAttribute(): Collection
    {
        $images = collect();
        $this->getMedia('product_thumbnail')
            ->each(function ($image) use ($images) {
                $images->push($image->getUrl());
            });
        return $images;
    }


    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($ticket) {
            $now = Carbon::now()->format('d-m-Y');
            $customer = $ticket->customer()->first();
            $company = $customer->company()->first();
            $ticket->number = sprintf('%s/%s/%s/%s', $company->business_name, $customer->id, $company->id, $ticket->type);
        });

    }

}
