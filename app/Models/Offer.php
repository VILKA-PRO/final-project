<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Offer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'topic_id', 'price_per_click', 'url', 'topic_id',
    ];
    protected $dates = ['deleted_at'];


    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Определите связь многие ко многим с тематиками
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topics');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
