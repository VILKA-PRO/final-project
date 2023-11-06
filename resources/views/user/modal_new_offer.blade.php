<div id="popupForm" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Заголовок окна (по желанию) -->
            <div class="modal-header">
                <h2 class="modal-title">Создание оффера</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Тело формы -->
            <div class="modal-body">
                <form class="row g-3 needs-validation" action="{{ route('createOffer') }}" method="post" novalidate id="new_offer_form">
                    @csrf

                    <div class="form-group">≈
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Введите ваше название" required>
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
                        <label for="price_per_click">Цена</label>
                        <input type="number" step="0.01" class="form-control" id="price_per_click" name="price_per_click" required>
                        <div class="invalid-feedback" id="price_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="url">Ссылка на сайт</label>
                        <input type="url" class="form-control" id="url" name="url" required>
                        <div class="invalid-feedback" id="url_error"></div>

                    </div>

                    <div class="form-group">
                        <div id="error-messages"></div> <!-- Блок для вывода ошибок валидации -->
                    </div>



                    <button type="submit" class="btn btn-primary">Создать оффер</button>
                </form>
            </div>
        </div>
    </div>
</div>