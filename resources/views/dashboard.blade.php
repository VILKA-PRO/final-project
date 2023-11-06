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
                                            Созданные оферы
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
                                    <!-- //OFFER SEARCH -->

                                    <div class="col-auto">
                                        <a hhref="#" id="openPopup">
                                            <button type="button" class="btn btn-outline-primary w-55">Создать оффер</button>
                                        </a>
                                    </div>
                                </div>
                                <!-- Table -->
                                <div class="table-responsive ">

                                    <table id="projectsTable" class="table align-middle table-edge table-nowrap mb-0 table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <!-- <th class="w-60px">No.</th> -->
                                                <th>Имя</th>
                                                <th>Тема</th>
                                                <th>Сайт</th>
                                                <th class="w-60px text-center">Подписчиков</th>
                                                <th class="w-60px text-center">Цена</th>
                                                <th class="w-60px text-center">Кликов</th>
                                                <th class="w-60px text-center">Расходы</th>
                                                <th class="w-60px ">Действия</th>
                                                <!-- <th class="text-end">Расходы</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="offers_tbody">
                                            @foreach($userOffers as $key => $offer)
                                            <tr class="table-row offer-row" data-id="{{ $offer->id }}">

                                                <!-- <td>1</td> -->
                                                <td class="offer-title">{{ $offer->title }}</td>
                                                <td>
                                                    <span class="badge text-bg-info-soft rounded-pill">
                                                    {{ $offer->topic->topic }}
                                                    </span><br>
                                                </td>
                                                <td class="offer-url"><a href="{{ $offer->url }}">{{ $offer->url }}</a></td>
                                                <td class="text-center ">{{ $offer->subscriptions->where('is_active', 1)->count() }}</td>
                                                <td class="text-center">&#36;{{ $offer->price_per_click }}</td>
                                                <td class="text-center">{{ $clicksByOffer[$offer->id]}}</td>
                                                <td class="text-center">&#36;{{ $spendsByOffer[$offer->id] /0.8}}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('offerPage', ['id' => $offer->id]) }}"><span class="badge text-bg-success-soft rounded-pill">&#x270E;</span></a>

                                                    <a href="{{ route('deleteOffer', ['id' => $offer->id]) }}" onclick="return confirm('Вы уверены, что хотите удалить эту запись?')">
                                                        <span class="badge text-bg-danger-soft rounded-pill">&#x2716;</span>
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

                </div>
            </div>
        </div>

    </div>



    <!-- Всплывающее окно (скрытое по умолчанию) -->
    @include('user.modal_new_offer')

</x-app-layout>