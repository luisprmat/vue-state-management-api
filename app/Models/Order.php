<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }
}
