<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'id_product',
        'id_payment',
        'qty',
    ];
}
