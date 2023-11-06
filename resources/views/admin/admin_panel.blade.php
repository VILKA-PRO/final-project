<x-app-layout>

    <div class="container-fluid">

      
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
                <div class="pt-6 text-gray-900">
                    <div class="row">
                        <div class="col">

                            <!-- Card -->
                            <div class="card border-0 card-h-100">
                                <div class="card-header border-0 card-header-space-between ">
                                    <div class="col"><!-- Title -->
                                        <h2 class="card-header-title h4 text-uppercase">
                                            Офферы в работе
                                        </h2>
                                    </div>

                                    <!-- OFFER SEARCH -->

                                    <div class="col-3 containerSearch mr-5">
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                <div class="input-group search-input-group">
                                                    <input type="text" class="form-control search-input" id="search-input" placeholder="&#128269;   Название Оффера или URL">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                                <!-- Table -->
                                <div class="table-responsive ">

                                    <table id="projectsTable" class="table align-middle table-edge table-nowrap mb-0 table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <!-- <th class="w-60px">No.</th> -->
                                                <th>Название</th>
                                                <th>Тема</th>
                                                <th>Ваш уникальный URL</th>
                                                <!-- <th class="w-60px text-center">Подписчиков</th> -->
                                                <th class="w-60px text-center">Цена</th>
                                                <th class="w-60px text-center">Кликов</th>
                                                <th class="w-60px text-center">Доход</th>
                                                <th class="w-60px ">Действия</th>
                                                <!-- <th class="text-end">Расходы</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="projectsTbody">
                                            @foreach($subscribedOffers as $key => $offer)
                                            @php
                                            // Предполагаем, что у пользователя только одна подписка на оффер
                                            $subscription = $offer->subscriptions->first();
                                            @endphp
                                            <tr class="table-row admin-offer-row" data-id="{{ $offer->id }}" subscription_id="{{ $subscription->id }}">

                                                <!-- <td>1</td> -->
                                                <td class="offer-title">{{ $offer->title }}</td>
                                                <td class="offer-topic">
                                                    <span class="badge text-bg-info-soft rounded-pill">
                                                        {{ $offer->topic->topic }}
                                                    </span><br>
                                                </td>

                                                <td class="offer-url"><a href="#">{{ $subscription->unique_url }}</a>
                                                    <button id="copyButton"><i class="fas fa-copy" style="color: #0699ac;"></i></button>
                                                    <div id="tooltip" class="">Текст скопирован в буфер обмена</div>
                                                </td>
                                                <!-- <td class="text-center ">{{ $offer->subscriptions->count() }}</td> -->
                                                <td class="text-center price_per_click">&#36;{{ $offer->price_per_click * 0.8}}</td>
                                                <td class="text-center clicksByOffer">{{ $clicksByOffer[$offer->id] ?? 0 }}</td>
                                                <td class="text-center incomesByOffer">&#36;{{ $incomesByOffer[$offer->id] ?? '0.00' }}</td>
                                                <td class="text-center unSubscribe">
                                                    <a href="{{ route('unSubscribe', ['id' => $subscription->id]) }}" onclick="return confirm('Вы уверены, что хотите отписаться от этого оффера?')">
                                                        <span class="badge text-bg-danger-soft rounded-pill">Отписаться</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div> <!-- / .table-responsive -->
                            </div>
                        </div>
                    </div> <!-- / .row -->
                    @if (session('status'))
                    <div class="alert alert-info">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col">

                            <!-- Card -->
                            <div class="card border-0 card-h-100">
                                <div class="card-header border-0 card-header-space-between ">
                                    <div class="col"><!-- Title -->
                                        <h2 class="card-header-title h4 text-uppercase">
                                            Доступные офферы
                                        </h2>
                                    </div>

                                    <!-- OFFER SEARCH -->

                                    <div class="col-3 containerSearch mr-5">
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                <div class="input-group search-input-group">
                                                    <input type="text" class="form-control search-input" id="search-input2" placeholder="&#128269;   Название Оффера или URL">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- //OFFER SEARCH -->

                                    <!-- <div class="col-auto">
                                        <a hhref="#" id="openPopup">
                                            <button type="button" class="btn btn-outline-primary w-55">Создать оффер</button>
                                        </a>
                                    </div> -->
                                </div>


                                <!-- Table availableOffersTable -->
                                <div class="table-responsive ">

                                    <table id="availableOffersTable" class="table align-middle table-edge table-nowrap mb-0 table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <!-- <th class="w-60px">No.</th> -->
                                                <th>Название</th>
                                                <th>Тема</th>
                                                <th>Сайт</th>
                                                <!-- <th class="w-60px text-center">Подписчиков</th> -->
                                                <th class="w-60px text-center">Цена</th>
                                                <!-- <th class="w-60px text-center">Кликов</th>
                                                <th class="w-60px text-center">Расходы</th> -->
                                                <th class="w-60px ">Действия</th>
                                                <!-- <th class="text-end">Расходы</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="availableOffersTbody">
                                            @foreach($notSubscribedOffers as $key => $offer)
                                            <tr class="table-row available-offer-row" data-id="{{ $offer->id }}">

                                                <!-- <td>1</td> -->
                                                <td class="offer-title">{{ $offer->title }}</td>
                                                <td class="offer-topic">
                                                    <span class="badge text-bg-info-soft rounded-pill">
                                                        {{ $offer->topic->topic }}
                                                    </span><br>
                                                </td>
                                                <td class="offer-url"><a href="{{ $offer->url }}">{{ $offer->url }}</a></td>
                                                <td class="text-center price_per_click">&#36;{{ $offer->price_per_click  * 0.8}}</td>
                                                <td class="text-center signToOffer">
                                                    <a href="{{ route('signToOffer', ['id' => $offer->id]) }}"><span class="badge text-bg-success-soft rounded-pill">Подписаться</span></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div> <!-- / .table-responsive -->
                            </div>
                        </div>
                    </div> <!-- / .row -->

                </div>
            </div>
        </div>

    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

</x-app-layout>