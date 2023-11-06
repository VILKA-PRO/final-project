<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Topic;
use App\Models\User;
use App\Models\Offer;

class DashboardController extends Controller
{


    public function showUserOffers()
    {
        $user = auth()->user(); // Получите текущего аутентифицированного пользователя
        $userOffers = $user->offers()->with(['topic', 'subscriptions.clicks'])->get(); // Оптимизированная загрузка связей
        $clicksByOffer = [];
        $spendsByOffer = [];


        // Перебираем каждый оффер
        foreach ($userOffers as $offer) {
            // Считаем количество кликов для каждого оффера
            $clicksByOffer[$offer->id] = $offer->subscriptions->reduce(function ($carry, $subscription) {
                return $carry + $subscription->clicks->sum('click_count');
            }, 0);

            // Считаем сумму затрат на клики для каждого оффера
            $spendsByOffer[$offer->id] = $offer->subscriptions->reduce(function ($carry, $subscription) {
                return $carry + $subscription->clicks->sum('click_cost');
            }, 0);
        }

        $topics = Topic::all(); // Получаем все темы из базы данных

        return view('dashboard', [
            'user' => $user,
            'userOffers' => $userOffers,
            'clicksByOffer' => $clicksByOffer,
            'spendsByOffer' => $spendsByOffer,
            'topics' => $topics,
        ]);
    }
}
