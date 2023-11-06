<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Click;
use Illuminate\Support\Facades\Log;

class ClickTrackingController extends Controller
{
    public function trackClick(Request $request)
    {
        // Проверяем наличие необходимых параметров
        $fullUrl = $request->fullUrl();
        $ref = $request->query('ref');
        $userId = $request->query('user_id');
        $subscription = Subscription::where('unique_url', 'like', '%' . $ref . '%')
            ->where('user_id', $userId)->where('is_active', 1)
            ->first();

        // Если подписка не найдена, возвращаем ошибку 404
        if (!$subscription) {
            Log::channel('clickTracking')->error("Ошибка перехода по URL: {$fullUrl}. Такой подписки не существует.");
            abort(404);
        }

        // Создаем запись в таблице Clicks
        $click = new Click();
        $click->subscription_id = $subscription->id;
        $click->click_count = 1; // Предполагаем, что каждый переход - это 1 клик
        $click->click_cost = $subscription->offer->price_per_click * 0.8; // Стоимость клика берется из цены оффера
        $click->save();

        // Записываем в лог факт перехода
        Log::channel('clickTracking')->info("Переход по уникальному URL: {$fullUrl}");

        // Перенаправляем клиента на целевой URL
        return redirect($subscription->offer->url);
    }
}
