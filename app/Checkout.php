<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
    ];
}
