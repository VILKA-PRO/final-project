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

                            <!-- Card -->
                            <div class="row ">
                                <div class="col-xxl-4">
                                    <div class="row ">
                                        <div class="col-md-12 ">
                                            <div class="row ">
                                                <h1 class="h2">
                                                    {{ $offer->title }}
                                                </h1>
                                            </div>
                                            <div class="row ">
                                                <div class="col-12 mb-2">
                                                    <span class=" small text-muted">Тема:</span>
                                                    <span class="badge badge-big text-bg-info-soft rounded-pill">{{ $topic->topic }}</span>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-12 mb-2">
                                                    <span class=" small text-muted">URL:</span>
                                                    <a href="#" id="textToCopy">{{ $subscription->unique_url }}</a>
                                                    <button id="copyButton"><i class="fas fa-copy" style="color: #0699ac;"></i></button>
                                                    <div id="tooltip" class="">Текст скопирован в буфер обмена</div>

                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-12 mb-2">
                                                    <span class=" small text-muted">Текущая цена:</span>
                                                    <span class=" big text-bold">&#36;{{ $offer->price_per_click * 0.8}}</span>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-12 mb-5">

                                                    <a href="{{ route('unSubscribe', ['id' => $subscription->id]) }}" onclick="return confirm('Вы уверены, что хотите отписаться от этого оффера?')">
                                                        <span class="badge text-bg-danger-soft rounded-pill">Отписаться от оффера</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Всего кликов -->
                                        <div class="col-md-6">
                                            <div class="card border-0 card-h-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-between">
                                                            <div>
                                                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                                                    <span class="legend-circle-sm bg-danger"></span>
                                                                    Всего кликов
                                                                </h5>
                                                                <h2 class="mb-0">
                                                                    {{ $clicksByOffer}}
                                                                </h2>
                                                                <p class="fs-6 text-muted mb-0 text-truncate">
                                                                    по данному офферу
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Расходы -->
                                        <div class="col-md-6">
                                            <div class="card border-0 card-h-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-between">
                                                            <div>
                                                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                                                    <span class="legend-circle-sm bg-danger"></span>
                                                                    Расходы
                                                                </h5>
                                                                <h2 class="mb-0">
                                                                    &#36;{{ $spendsByOffer}}
                                                                </h2>
                                                                <p class="fs-6 text-muted mb-0 text-truncate">
                                                                    по данному офферу
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



                                </div>


                                <div class="col-xxl-8">
                                    <!-- Card CHART-->
                                    <div class="col-md-12 ">
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
    </script>


</x-app-layout>