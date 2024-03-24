<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TicketHistory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $employee = $model->employee()->first();
            $ticket = $model->ticket()->first();
            $model->number = sprintf('%s/%s/%s', $ticket->id, $employee->id, $model->id);
        });

    }

}
