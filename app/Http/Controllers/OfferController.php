<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Offer;
use App\Models\Click;
use App\Models\OfferTopic;
use Illuminate\Support\Facades\Validator;
use App\Models\Topic;
use Carbon\Carbon;


class OfferController extends Controller
{

    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'price_per_click' => 'required|numeric',
            'url' => 'required|url',
        ];

        $messages = [
            'title.required' => 'Название обязательно',
            'price_per_click.required' => 'Цена обязательна',
            'price_per_click.number' => 'Пожалуйста, введите положительное целое или десятичное число',
            'url.required' => 'URL обязателен',
            'url.url' => 'Пожалуйста, введите коректный URL',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);



        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }


        // Создание нового оффера
        $offer = new Offer;
        $offer->title = $request->input('title');
        $offer->topic_id = $request->input('topic_id');
        $offer->price_per_click = $request->input('price_per_click');
        $offer->url = $request->input('url');
        $offer->user_id = auth()->user()->id;
        $offer->save();

        $offerId = $offer->id;

        // $selectedTopicId = $request->input('topic_id');
        // $offerTopic = new OfferTopic;
        // $offerTopic->offer_id = $offerId;
        // $offerTopic->topic_id = $selectedTopicId;
        // $offerTopic->save();
        // версия если несколько тем выбрано. Нужен массив на входе.
        // $selectedTopicIds = $request->input('topic_id');
        // foreach ($selectedTopicIds as $topicId) {
        //     $offerTopic = new \App\Models\OfferTopic;
        //     $offerTopic->offer_id = $offerId;
        //     $offerTopic->topic_id = $topicId;
        //     $offerTopic->save();
        // }

        $newData = [
            // Здесь добавьте все необходимые данные, которые вы только что добавили
            'title' => $request->input('title'),
            'price_per_click' => $request->input('price_per_click'),
            'url' => $request->input('url'),
            'topic_id' => $request->input('topic_id'),
            'offer_id' => $offerId,
        ];

        // return redirect()->route('offer.index')->with('success', 'Оффер успешно создан');
        return response()->json(['success' => true, 'data' => $newData]);
    }


    public function deleteOffer($id)
    {
        $offer = Offer::find($id); // Находим запись по идентификатору
        if ($offer) {
            $offer->delete(); // Удаляем запись
            return Redirect::route('dashboard')->with('status', 'Запись удалена');
        } else {
            return Redirect::route('dashboard')->with('status', 'Запись не найдена');
            // Запись не найдена, обработка ошибки
        }
    }

    public function offerPage($id)
    {
        $offer = Offer::find($id); // Находим запись по идентификатору

        if (!$offer) {
            return redirect()->route('dashboard')->with('status', 'Запись не найдена');
        }

        $user = auth()->user(); // Получите текущего аутентифицированного пользователя

        // Для каждого оффера, получите связанные подписки (subscriptions)
        $offer->load('subscriptions.clicks'); // Загружаем связанные подписки и клики

        // Для каждой подписки, пройдите и посчитайте клики и суммируйте их
        $clicksByOffer = 0;

        foreach ($offer->subscriptions as $subscription) {
            $clicksByOffer += $subscription->clicks->sum('click_count');
        }

        // Расходы
        $spendsByOffer = 0;
        foreach ($offer->subscriptions as $subscription) {
            $spendsByOffer += $subscription->clicks->sum('click_cost');
        }
        // $spendsByOffer =  $clicksByOffer * $offer->price_per_click; // умнажаем на текущую цену

        $topic = $offer->topic; // Получаем объект темы, связанный с оффером
        $topics = Topic::all(); // Получаем все темы из базы данных

        //ДЛЯ ГРАФИКА

        // Получите все клики для данного оффера
        $clicks = $offer->subscriptions->flatMap(function ($subscription) {
            return $subscription->clicks;
        });
        // Группируйте клики по датам и сортируйте их
        $clicksByDay = $clicks->groupBy(function ($click) {
            return $click->created_at->format('Y-m-d');
        })->sortBy(function ($clicks) {
            return $clicks->first()->created_at; // Сортировка по дате первого клика в группе
        });

        // Рассчитайте сумму кликов и расходов для каждой даты
        $clicksData = $clicksByDay->map(function ($clicks) {
            return $clicks->sum('click_count');
        });
        $spendsData = $clicksByDay->map(function ($clicks) {
            return $clicks->sum('click_cost');
        });
        $combinedData = $clicksData->map(function ($clicks, $date) use ($spendsData) {
            return [
                // 'date' => $date,
                'clicks' => $clicks,
                'spends' => $spendsData[$date],
            ];
        });
        
        // Создайте массив с датами для использования в графике
        $labels = $clicksByDay->keys()->toArray();

        return view('user.edit_offer', [
            'user' => $user,
            'offer' => $offer,
            'clicksByOffer' => $clicksByOffer,
            'spendsByOffer' => $spendsByOffer,
            'topics' => $topics,
            'topic' => $topic,
            'clicksData' => $clicksData,
            'spendsData' => $spendsData,
            'labels' => $labels,
            'combinedData' => $combinedData,
            
        ]);
    }




    public function editOffer(Request $request, $id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            // Обработка случая, когда оффер не найден
            return redirect()->route('offerPage')->with('error', 'Оффер не найден');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'price_per_click' => 'required|numeric',
            'url' => 'required|url',
        ];

        $messages = [
            'title.required' => 'Название обязательно',
            'price_per_click.required' => 'Цена обязательна',
            'price_per_click.number' => 'Пожалуйста, введите положительное целое или десятичное число',
            'url.required' => 'URL обязателен',
            'url.url' => 'Пожалуйста, введите коректный URL',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        // Обновление данных оффера
        $offer->title = $request->input('title');
        $offer->price_per_click = $request->input('price_per_click');
        $offer->url = $request->input('url');
        $offer->topic_id = $request->input('topic_id');
        $offer->save();

        // return redirect()->route('offerPage', ['id' => $offer->id])->with('success', 'Оффер успешно обновлен');
        return response()->json(['success' => true, 'successMsg' => 'Оффер успешно обновлен']);
    }


    public function getOfferChartData($id)
    {
        $offer = Offer::find($id);
        if (!$offer) {
            return response()->json(['error' => 'Оффер не найден']);
        }

        $clicksData = $offer->subscriptions->groupBy(function ($subscription) {
            return $subscription->created_at->format('Y-m-d'); // Группируем по дням
        })->map(function ($grouped) {
            return $grouped->sum('clicks'); // Суммируем клики по дням
        });

        $expensesData = $clicksData->map(function ($clicks, $date) use ($offer) {
            return $clicks * $offer->price_per_click; // Рассчитываем расходы
        });

        return response()->json(['clicks' => $clicksData, 'expenses' => $expensesData]);
    }
}
