<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $appends = ['photo'];

    protected $hidden = ['media'];

    public const mapType = [
        'RECORDING' => 'Recording',
        'REGULAR' => 'Regular',
        'PRIORITY' => 'Priority'
    ];

    public const mapStatus =  [
        'ADMIN_APPROVED' => 'Admin Approved',
        'CUSTOMER_APPROVED' => 'Customer Approved',
        'WORKING' => 'Working',
        'NEED_ADMIN_REVIEW' => 'Need Admin Review',
        'DONE' => 'Done',
        'CANCEL' => 'Cancel',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo');
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


    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($ticket) {
            $customer = $ticket->customer()->first();
            $company = $customer->company()->first();
            $ticket->number = sprintf('%s/%s/%s/%s', $company->business_name, $customer->id, $company->id, $ticket->type);
        });

    }

}
