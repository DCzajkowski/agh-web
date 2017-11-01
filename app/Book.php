<?php

namespace App;

use App\Checkout;
use App\Publisher;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function isAvailable()
    {
        return ! (bool) $this->checkouts->where('is_returned', false)->count();
    }
}
