<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['unique_url', 'user_id', 'offer_id', 'is_active'];
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    // Связь с моделью Click (одна подписка имеет много кликов)
    public function clicks()
    {
        return $this->hasMany(Click::class);
    }
}
