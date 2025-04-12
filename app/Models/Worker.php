<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Worker extends Model
{
    protected $fillable = [
        'name', 'second_name', 'surname', 'phone',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_worker')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function excludedTypes(): BelongsToMany
    {
        return $this->belongsToMany(OrderType::class, 'workers_ex_order_types');
    }
}
