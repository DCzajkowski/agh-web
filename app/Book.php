<?php

namespace App;

use App\Publisher;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
