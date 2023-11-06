<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $fillable = ['subscription_id']; // Указываем, какие поля можно заполнять

    // Связь с моделью Subscription (многие клики принадлежат одной подписке)
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    //Связь с таблицей "Offers" через "Subscriptions": Если вы хотите получить информацию о предложении, связанном с кликом, через таблицу "Subscriptions"
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id')->through('subscription');
    }
}
