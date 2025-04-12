<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderType extends Model
{
    protected $fillable = ['name'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'type_id');
    }

    public function excludedByWorkers()
    {
        return $this->belongsToMany(Worker::class, 'workers_ex_order_types');
    }
}
