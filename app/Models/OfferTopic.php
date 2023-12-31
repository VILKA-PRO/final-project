<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTopic extends Model
{
    use HasFactory;
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
