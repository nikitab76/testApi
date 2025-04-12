<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'partnership_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function partnership(): BelongsTo
    {
        return $this->belongsTo(Partnership::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
