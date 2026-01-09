<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected function casts(): array
    {
        return [
            'use_for_upselling' => 'boolean',
        ];
    }
}
