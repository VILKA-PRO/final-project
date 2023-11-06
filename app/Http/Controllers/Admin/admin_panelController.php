<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Topic;
use App\Models\Offer;
use App\Models\Click;
use App\Models\Subscription;
use Illuminate\Support\Facades\Response;


class admin_panelController extends Controller
{

    public function showUserOffers()
    {

        $user = auth()->user(); // Получите текущего аутентифицированного пользователя
        $userId = $user->id;


        // Собираем офферы, на которые пользователь подписан
        // $subscribedOffers = Offer::with(['subscriptions' => function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // }])->whereHas('subscriptions', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })->get();

        $subscribedOffers = Offer::with(['subscriptions' => function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('is_active', 1);
        }])->whereHas('subscriptions', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('is_active', 1);
        })->get();


        // Собираем офферы, на которые пользователь не подписан
        // $notSubscribedOffers = Offer::whereDoesntHave('subscriptions', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })->get();

        // Сначала получаем все офферы с их подписками для данного пользователя
        $offers = Offer::with(['subscriptions' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();

        // Теперь фильтруем эти офферы, оставляя те, на которые пользователь не подписан или подписка неактивна
        $notSubscribedOffers = $offers->filter(function ($offer) use ($userId) {
            // Проверяем, нет ли активных подписок у пользователя на этот оффер
            $activeSubscription = $offer->subscriptions->first(function ($subscription) {
                return $subscription->is_active;
            });

            // Если активных подписок нет, то либо пользователь не был подписан, либо подписка неактивна
            return is_null($activeSubscription);
        });

        // Если нужно получить коллекцию Eloquent, а не базовую коллекцию Laravel
        $notSubscribedOffers = $notSubscribedOffers->values();

        // Подсчитываем сумму кликов и доходов для каждого оффера
        $clicksByOffer = [];
        $incomesByOffer = [];
        foreach ($subscribedOffers as $offer) {
            $totalClicks = Click::join('subscriptions', 'clicks.subscription_id', '=', 'subscriptions.id')
                ->where('subscriptions.offer_id', $offer->id)
                ->where('subscriptions.user_id', $userId)
                ->sum('clicks.click_count');

            $totalIncome = Click::join('subscriptions', 'clicks.subscription_id', '=', 'subscriptions.id')
                ->where('subscriptions.offer_id', $offer->id)
                ->where('subscriptions.user_id', $userId)
                ->sum('clicks.click_cost');

            $clicksByOffer[$offer->id] = $totalClicks;
            $incomesByOffer[$offer->id] = $totalIncome;
        }


        return view('admin.admin_panel', [
            'user' => $user,
            'clicksByOffer' => $clicksByOffer,
            'incomesByOffer' => $incomesByOffer,
            'subscribedOffers' => $subscribedOffers,
            'notSubscribedOffers' => $notSubscribedOffers,
            // 'price_per_click_for_admin' => $offer->price_per_clickdmin,
        ]);
    }

    public function signToOfferOLD(Request $request, $id)
    {
        $user = auth()->user();
        $offer = Offer::findOrFail($id);

        // Проверяем, существует ли уже подписка на этот оффер для данного пользователя
        $subscription = Subscription::where('user_id', $user->id)
            ->where('offer_id', $offer->id)
            ->first();

        if ($subscription) {
            // Если подписка существует, но не активна, активируем её
            if (!$subscription->is_active) {
                $subscription->is_active = 1;
                $subscription->save();
                return back()->with('message', 'Ваша подписка на оффер была успешно активирована.');
            } else {
                // Если подписка активна, информируем пользователя
                return back()->with('message', 'Вы уже подписаны на этот оффер.');
            }
        } else {
            // Если подписки не существует, создаем новую
            $uniqueUrl = 'http://127.0.0.1:8000/track-click?ref=' . Str::random(10) . '&user_id=' . $user->id;

            $subscription = Subscription::create([
                'unique_url' => $uniqueUrl,
                'user_id' => $user->id,
                'offer_id' => $offer->id,
                'is_active' => 1,
            ]);

            return back()->with('message', 'Подписка на оффер успешно оформлена.');
        }
    }



    public function signToOffer(Request $request, $id)
    {
        $user = auth()->user();
        $offer = Offer::findOrFail($id);

        // Проверяем, существует ли уже подписка на этот оффер для данного пользователя
        $subscription = Subscription::where('user_id', $user->id)
            ->where('offer_id', $offer->id)
            ->first();

        if ($subscription) {
            // Если подписка существует, но не активна, активируем её
            if (!$subscription->is_active) {
                $subscription->is_active = 1;
                $subscription->save();

                if ($request->ajax()) {
                    // Если запрос AJAX, возвращаем JSON ответ
                    $message = 'Ваша подписка на оффер была успешно активирована';
                    return Response::json([
                        'message' => $message,
                        'subscriptionId' => $subscription->id ?? null,
                        'isActive' => $subscription->is_active ?? null,
                    ]);
                }
                return back()->with('message', 'Ваша подписка на оффер была успешно активирована.');
            } else {
                // Если подписка активна, информируем пользователя
                return back()->with('message', 'Вы уже подписаны на этот оффер.');
            }
        } else {
            // Если подписки не существует, создаем новую
            $uniqueUrl = 'http://127.0.0.1:8000/track-click?ref=' . Str::random(10) . '&user_id=' . $user->id;

            $subscription = Subscription::create([
                'unique_url' => $uniqueUrl,
                'user_id' => $user->id,
                'offer_id' => $offer->id,
                'is_active' => 1,
            ]);

            if ($request->ajax()) {
                // Если запрос AJAX, возвращаем JSON ответ
                $message = 'Подписка на оффер успешно оформлена.';
                return Response::json([
                    'message' => $message,
                    'subscriptionId' => $subscription->id ?? null,
                    'isActive' => $subscription->is_active ?? null,
                ]);
            }
            return back()->with('message', 'Подписка на оффер успешно оформлена.');

        }

        

    }
}
