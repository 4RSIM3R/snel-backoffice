<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticate;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticate implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password'];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
