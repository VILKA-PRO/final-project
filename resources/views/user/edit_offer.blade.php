<x-app-layout>
    <div class="container-fluid">

        <!-- Title
        <div class="px-7 pt-6 text-gray-900">

            <h1 class="h2">
                CRM
            </h1>
        </div> -->
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
                <div class="pt-6 text-gray-900">
                    <div class="row">
                        <div class="col">

                            <h1 class="h2">
                                {{ $offer->title }}
                            </h1>
                            <div class="mb-5"><span class="badge badge-big text-bg-info-soft rounded-pill">{{ $topic->topic }}</span>
                                <a href="{{ $offer->url }}">{{ $offer->url }}</a>
                            </div>

                            <!-- Card -->
                            <div class="row ">
                                <div class="col-xxl-8">
                                    <div class="row ">
                                        <div class="col-md-4">

                                            <!-- Card -->
                                            <div class="card border-0 card-h-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-between">

                                                            <div>
                                                                <!-- Title -->
                                                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                                                    <span class="legend-circle-sm bg-success"></span>
                                                                    Подписчиков
                                                                </h5>

                                                                <!-- Subtitle -->
                                                                <h2 class="mb-0">
                                                                {{ $offer->subscriptions->where('is_active', 1)->count() }}
                                                                </h2>

                                                                <!-- Comment -->
                                                                <!-- <p class="fs-6 text-muted mb-0">
                                                                    Общее количество
                                                                </p> -->
                                                            </div>

                                                            <span class="text-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="32" width="32">
                                                                    <defs>
                                                                        <style>
                                                                            .a {
                                                                                fill: none;
                                                                                stroke: currentColor;
                                                                                stroke-linecap: round;
                                                                                stroke-linejoin: round;
                                                                                stroke-width: 1.5px;
                                                                            }
                                                                        </style>
                                                                    </defs>
                                                                    <title>cash-briefcase</title>
                                                                    <path class="a" d="M9.75,15.937c0,.932,1.007,1.688,2.25,1.688s2.25-.756,2.25-1.688S13.243,14.25,12,14.25s-2.25-.756-2.25-1.688,1.007-1.687,2.25-1.687,2.25.755,2.25,1.687"></path>
                                                                    <line class="a" x1="12" y1="9.75" x2="12" y2="10.875"></line>
                                                                    <line class="a" x1="12" y1="17.625" x2="12" y2="18.75"></line>
                                                                    <rect class="a" x="1.5" y="6.75" width="21" height="15" rx="1.5" ry="1.5"></rect>
                                                                    <path class="a" d="M15.342,3.275A1.5,1.5,0,0,0,13.919,2.25H10.081A1.5,1.5,0,0,0,8.658,3.275L7.5,6.75h9Z"></path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- Card -->
                                            <div class="card border-0 card-h-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-between">

                                                            <div>
                                                                <!-- Title -->
                                                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                                                    <span class="legend-circle-sm bg-danger"></span>
                                                                    Всего кликов
                                                                </h5>

                                                                <!-- Subtitle -->
                                                                <h2 class="mb-0">
                                                                    {{ $clicksByOffer}}
                                                                </h2>

                                                                <!-- Comment -->
                                                                <p class="fs-6 text-muted mb-0 text-truncate">
                                                                    От всех подписчиков
                                                                </p>
                                                            </div>

                                                            <span class="text-primary">
                                                                <svg viewBox="0 0 24 24" height="32" width="32" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M18.75,14.25H16.717a1.342,1.342,0,0,0-.5,2.587l2.064.826a1.342,1.342,0,0,1-.5,2.587H15.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M17.25 14.25L17.25 13.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M17.25 21L17.25 20.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M11.250 17.250 A6.000 6.000 0 1 0 23.250 17.250 A6.000 6.000 0 1 0 11.250 17.250 Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M3.75 14.25L8.25 14.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M8.25 14.25L8.25 6.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M11.25 9.75L11.25 8.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M5.25 14.25L5.25 9.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                    <path d="M7.5,20.25H2.25a1.43,1.43,0,0,1-1.5-1.415V2.335A1.575,1.575,0,0,1,2.25.75H12.879a1.5,1.5,0,0,1,1.06.439l2.872,2.872a1.5,1.5,0,0,1,.439,1.06V7.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- Card -->
                                            <div class="card border-0 card-h-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-between">

                                                            <div>
                                                                <!-- Title -->
                                                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                                                    <span class="legend-circle-sm bg-danger"></span>
                                                                    Расходы
                                                                </h5>

                                                                <!-- Subtitle -->
                                                                <h2 class="mb-0">
                                                                    &#36;{{ $spendsByOffer/0.8}}
                                                                </h2>

                                                                <!-- Comment -->
                                                                <p class="fs-6 text-muted mb-0 text-truncate">
                                                                    При цене клика: &#36;{{ $offer->price_per_click }}
                                                                </p>
                                                            </div>

                                                            <span class="text-primary">
                                                            </span>
                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- / .row -->

                                    <div class="col-md-12 ">
                                        <!-- Card -->

                                        <div class="card border-0 flex-fill w-100 card-h-100">
                                            <div class="card-header border-0 card-header-space-between">

                                                <!-- Title -->
                                                <h2 class="card-header-title h4 text-uppercase">
                                                    Статистика
                                                </h2>

                                                <ul class="nav" role="tablist">
                                                    <li class="nav-item" data-toggle="chart" data-target="#salesReportChart" data-dataset="0" role="presentation">
                                                        <a class="nav-link chart-legend active" href="#" data-bs-toggle="tab" aria-selected="true" role="tab" id="groupByDays">
                                                            <span class="legend-circle-lg bg-primary"></span>
                                                            По дням
                                                        </a>
                                                    </li>
                                                    <li class="nav-item" data-toggle="chart" data-target="#salesReportChart" data-dataset="1" role="presentation">
                                                        <a class="nav-link chart-legend" href="#" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1" id="groupByMonths">
                                                            <span class="legend-circle-lg bg-dark"></span>
                                                            по месяцам
                                                        </a>
                                                    </li>
                                                    <li class="nav-item" data-toggle="chart" data-target="#salesReportChart" data-dataset="1" role="presentation">
                                                        <a class="nav-link chart-legend" href="#" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1" id="groupByYears">
                                                            <span class="legend-circle-lg bg-dark"></span>
                                                            По годам
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="card-body d-flex flex-column">

                                                <!-- Chart -->
                                                <div class="chart-container flex-grow-1 h-275px">
                                                    <canvas id="myChart" style="display: block; box-sizing: border-box; height: 100%; width: 100%;"></canvas>
                                                    <!-- height: 275px; width: 995px;" width="995" height="275 -->

                                                </div>


                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="col-xxl-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Card  -->
                                            <div class="card border-0 flex-fill w-100 my-height card-h-100 ">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">

                                                            <!-- Title -->
                                                            <h5 class="text-uppercase text-muted fw-semibold mb-4">
                                                                Редактировать Оффер
                                                            </h5>

                                                            <!-- Форма редактирования -->
                                                            <form class="row g-3 needs-validation" action="{{ route('editOffer', ['id' => $offer->id]) }}" method="post" novalidate id="edit_offer_form">
                                                                @csrf

                                                                <div class="form-group">
                                                                    <label for="title" class="form-label">Название</label>
                                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Введите ваше название" value="{{ $offer->title }}" required>
                                                                    <div class="invalid-feedback" id="title_error"></div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="topic_id">Тема</label>

                                                                    <select class="form-control" id="topic_id" name="topic_id" required>
                                                                        @foreach ($topics as $topic)
                                                                        <option value="{{ $topic->id }}">{{ $topic->topic }}</option>
                                                                        @endforeach
                                                                    </select>


                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="price_per_click">Цена &#36;</label>
                                                                    <input type="number" step="0.01" class="form-control" id="price_per_click" name="price_per_click" value="{{ $offer->price_per_click }}" required>
                                                                    <div class="invalid-feedback" id="price_error"></div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="url">Ссылка на сайт</label>
                                                                    <input type="url" class="form-control" id="url" name="url" value="{{ $offer->url }}" required>
                                                                    <div class="invalid-feedback" id="url_error"></div>

                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Изменить оффер</button>
                                                            </form>


                                                        </div>

                                                        <div class="col-12 pt-3">
                                                            <a href="{{ route('deleteOffer', ['id' => $offer->id]) }}" onclick="return confirm('Вы уверены, что хотите удалить эту запись?')" class="link-danger">
                                                            Удалить Оффер
                                                            </a>
                                                            <!-- <a href="#" class="link-danger">Удалить Оффер</a> -->
                                                        </div>

                                                        <div class="col-12 pt-3" id="successMsg">
                                                            @if (session('success'))
                                                            <div class="alert alert-success">
                                                                {{ session('success') }}
                                                            </div>
                                                            @endif
                                                        </div>


                                                    </div> <!-- / .row -->
                                                </div>
                                            </div>
                                        </div>


                                    </div> <!-- / .row -->
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>

    <!-- {{$combinedData}}<br><br><br><br>
    {{$spendsData}} -->
    </script>
    <script>
        // Получение данных из PHP и преобразование их в JavaScript переменные
        // const labels = <?php echo json_encode($labels); ?>;
        // const clicksData = <?php echo json_encode($clicksData); ?>;
        // const spendsData = <?php echo json_encode($spendsData); ?>;
        const combinedData = <?php echo json_encode($combinedData); ?>;

        // console.log(combinedData);
    </script>


</x-app-layout>