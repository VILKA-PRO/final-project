import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
let chart;

if (
    window.location.pathname === "/dashboard" ||
    window.location.pathname === "/admin_panel"
) {
    // поиск по офферам
    document
        .getElementById("search-input")
        .addEventListener("input", function () {
            let searchTerm = this.value.toLowerCase();
            let offerRows = document.querySelectorAll(".offer-row");

            offerRows.forEach(function (offerRow) {
                let offeTitle = offerRow
                    .querySelector(".offer-title")
                    .textContent.toLowerCase();
                let offeUrl = offerRow
                    .querySelector(".offer-url")
                    .textContent.toLowerCase();

                if (
                    offeTitle.includes(searchTerm) ||
                    offeUrl.includes(searchTerm)
                ) {
                    offerRow.removeAttribute("style");
                } else {
                    offerRow.style.display = "none";
                }
            });
        });

    if (window.location.pathname === "/admin_panel") {
        document
            .getElementById("search-input2")
            .addEventListener("input", function () {
                let searchTerm = this.value.toLowerCase();
                let offerRows = document.querySelectorAll(
                    ".available-offer-row"
                );

                offerRows.forEach(function (offerRow) {
                    let offeTitle = offerRow
                        .querySelector(".offer-title")
                        .textContent.toLowerCase();
                    let offeUrl = offerRow
                        .querySelector(".offer-url")
                        .textContent.toLowerCase();

                    if (
                        offeTitle.includes(searchTerm) ||
                        offeUrl.includes(searchTerm)
                    ) {
                        offerRow.removeAttribute("style");
                    } else {
                        offerRow.style.display = "none";
                    }
                });
            });
    }
}

// СКОПИРОВАТЬ В БУФФЕР ССЫЛКУ. КНОПКА

document.addEventListener("DOMContentLoaded", function () {
    const copyButton = document.getElementById("copyButton");
    const textToCopy = document.getElementById("textToCopy");
    const tooltip = document.getElementById("tooltip");
    if (copyButton) {
        const clipboard = new ClipboardJS(copyButton, {
            text: function () {
                return textToCopy.textContent;
            },
        });

        clipboard.on("success", function (e) {
            // Показать tooltip
            tooltip.style.display = "block";
            tooltip.classList.add("active");

            // Скрыть tooltip через 1 секунду
            setTimeout(() => {
                tooltip.classList.remove("active");
                tooltip.style.display = "none";
            }, 1000);
            // alert("Текст скопирован в буфер обмена");
            e.clearSelection();
        });
    }
    // ПЕРЕТАСКИВАНИЕ СТРОК
    if (window.location.pathname === "/admin_panel") {
        // Для таблицы, из которой будем перетаскивать строки
        new Sortable(document.getElementById("availableOffersTbody"), {
            group: "shared", // Установите группу для обеих таблиц
            animation: 150,
        });

        // Для таблицы, в которую будем перетаскивать строки
        new Sortable(document.getElementById("projectsTbody"), {
            group: "shared",
            animation: 150,
            onAdd: function (event) {
                // Получение данных о перетаскиваемом элементе
                var itemEl = event.item; // HTMLElement, который был перетаскиваем
                var offerId = itemEl.dataset.id; // ID оффера

                // Добавляем новые ячейки и изменяем существующие
                addNewCells(itemEl, offerId);

                // AJAX-запрос для подписки на оффер
                fetch(`/admin_panel/${offerId}/sign`, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ id: offerId }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                "Network response was not ok " +
                                    response.statusText
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        console.log(data.message);
                        // Можете добавить логику для обновления UI здесь
                        // Например, убрать строку из исходной таблицы или обновить статус
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        // Обработка ошибки, возможно отображение сообщения пользователю
                    });
            },
            onRemove: function (event) {
                var itemEl = event.item;

                // Удаляем добавленные ячейки и возвращаем ячейку подписаться
                removeCells(itemEl);

                var subscriptionId = itemEl.getAttribute("subscription_id");
                fetch(`/admin_panel/${subscriptionId}/unSubscribe`, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ id: subscriptionId }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data.message);
                        // Обработайте ответ, обновите UI
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        // Обработайте ошибку, покажите сообщение пользователю
                    });
            },
        });

        // Функция для добавления новых ячеек при перетаскивании
        function addNewCells(row, offerId) {
            // Создаем ячейки для кликов и доходов
            let clicksCell = document.createElement("td");
            clicksCell.className = "text-center clicksByOffer";
            clicksCell.textContent = "0"; // Подставьте фактические данные с сервера

            let incomesCell = document.createElement("td");
            incomesCell.className = "text-center incomesByOffer";
            incomesCell.textContent = "$0.00"; // Подставьте фактические данные с сервера

            // Находим ячейку с ценой и вставляем новые ячейки после нее
            let priceCell = row.querySelector(".price_per_click");
            priceCell.parentNode.insertBefore(
                clicksCell,
                priceCell.nextSibling
            );
            priceCell.parentNode.insertBefore(
                incomesCell,
                clicksCell.nextSibling
            );

            // Заменяем ячейку подписаться на отписаться
            let subscribeCell = row.querySelector(".signToOffer");
            if (subscribeCell) {
                let unSubscribeCell = document.createElement("td");
                unSubscribeCell.className = "text-center unSubscribe";
                unSubscribeCell.innerHTML =
                    '<a href="#" onclick="unSubscribeOffer(event, ' +
                    offerId +
                    ')"><span class="badge text-bg-danger-soft rounded-pill">Отписаться</span></a>';

                subscribeCell.parentNode.replaceChild(
                    unSubscribeCell,
                    subscribeCell
                );
            }
        }

        // Функция для удаления ячеек при перетаскивании
        function removeCells(row) {
            // Удаляем ячейки кликов и доходов
            let urlCell = row.querySelector(".offer-url");
            let clicksCell = row.querySelector(".clicksByOffer");
            let incomesCell = row.querySelector(".incomesByOffer");
            if (clicksCell && incomesCell) {
                clicksCell.remove();
                incomesCell.remove();
            }

            // Заменяем ячейку отписаться на подписаться
            let unSubscribeCell = row.querySelector(".unSubscribe");
            if (unSubscribeCell) {
                let subscribeCell = document.createElement("td");
                subscribeCell.className = "text-center signToOffer";
                subscribeCell.innerHTML =
                    '<a href="#" onclick="subscribeOffer(event, ' +
                    row.dataset.id +
                    ')"><span class="badge text-bg-success-soft rounded-pill">Подписаться</span></a>';

                unSubscribeCell.parentNode.replaceChild(
                    subscribeCell,
                    unSubscribeCell
                );
            }
        }

        // ОТОБРАЖЕНИЕ ПУСТОЙ СТРОКИ, ЕСЛИ НЕТ ОФФЕРОВ
        var projectsTbody = document.getElementById("projectsTbody");

        function updateEmptyMessage() {
            // Проверяем, есть ли строки в tbody
            if (projectsTbody.rows.length === 0) {
                // Строк нет, добавляем строку с сообщением
                var tr = document.createElement("tr");
                tr.innerHTML =
                    '<td colspan="7" class="text-center">Вы не подписаны ни на один оффер. Перетащите сюда оффер снизу или нажмите подписаться.</td>';
                tr.classList.add("empty-message-row");
                projectsTbody.appendChild(tr);
            } else {
                // Строки есть, удаляем строку с сообщением, если она существует
                var emptyMessageRow =
                    projectsTbody.querySelector(".empty-message-row");
                if (emptyMessageRow) {
                    projectsTbody.removeChild(emptyMessageRow);
                }
            }
        }

        // Вызываем функцию при загрузке
        updateEmptyMessage();

        // Вызываем функцию при изменении содержимого tbody
        // Это может быть вызвано вручную после добавления/удаления строк через JavaScript
        projectsTbody.addEventListener(
            "DOMSubtreeModified",
            updateEmptyMessage
        );
    }

    if (window.location.pathname === "/dashboard") {
        // ОТОБРАЖЕНИЕ ПУСТОЙ СТРОКИ, ЕСЛИ НЕТ ОФФЕРОВ dashboard
        var projectsTbody = document.getElementById("offers_tbody");

        function updateEmptyMessage() {
            // Проверяем, есть ли строки в tbody
            if (projectsTbody.rows.length === 0) {
                // Строк нет, добавляем строку с сообщением
                var tr = document.createElement("tr");
                tr.innerHTML =
                    '<td colspan="7" class="text-center">У вас еще нет офферов. Нажмите "Создать оффер"</td>';
                tr.classList.add("empty-message-row");
                projectsTbody.appendChild(tr);
            } else {
                // Строки есть, удаляем строку с сообщением, если она существует
                var emptyMessageRow =
                    projectsTbody.querySelector(".empty-message-row");
                if (emptyMessageRow) {
                    projectsTbody.removeChild(emptyMessageRow);
                }
            }
        }

        // Вызываем функцию при загрузке
        updateEmptyMessage();

        // Вызываем функцию при изменении содержимого tbody
        // Это может быть вызвано вручную после добавления/удаления строк через JavaScript
        projectsTbody.addEventListener(
            "DOMSubtreeModified",
            updateEmptyMessage
        );
    }
});

// Клик по строке таблицы
document.querySelectorAll(".offer-row").forEach((row) => {
    const id = row.getAttribute("data-id");
    row.addEventListener("click", () => {
        window.location.href = `/dashboard/${id}`; // `{{ route('offerPage', ${id}) }}`; //
    });
});

document.querySelectorAll(".admin-offer-row").forEach((row) => {
    const id = row.getAttribute("data-id");
    row.addEventListener("click", () => {
        window.location.href = `/admin_panel/${id}`; // `{{ route('offerPage', ${id}) }}`; //
    });
});

// Валидация полей бутстрап
(() => {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll(".needs-validation");

    // Loop over them and prevent submission
    Array.from(forms).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
})();

// Создание нового оффера в модалке
// $(document).ready(function () {
// При клике на ссылку открываем всплывающее окно
$("#openPopup").click(function () {
    $("#popupForm").modal("show");
});

// Предотвращает закрытия окна если есть ошибки
$("#new_offer_form").submit(function (e) {
    e.preventDefault(); // Предотвращаем отправку формы по умолчанию

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function (response) {
            if (response.success) {
                $("#popupForm").modal("hide"); // Закрываем модальное окно после успешного сохранения
                location.reload(); // перезагружаем страницу, чтобы обновить данные
            } else {
                // JavaScript код для отображения ошибок
                var errorMessages = response.errors;

                if (errorMessages) {
                    // Очищаем контейнер от предыдущих ошибок
                    $("#title_error").empty();
                    $("#title_error").append(errorMessages.title);
                    $("#price_error").empty();
                    $("#price_error").append(errorMessages.price_per_click);
                    $("#url_error").empty();
                    $("#url_error").append(errorMessages.url);
                }
            }
        },
    });
});

// Редактирование оффера
$("#edit_offer_form").submit(function (e) {
    e.preventDefault(); // Предотвращаем отправку формы по умолчанию

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function (response) {
            if (response.success) {
                location.reload();
                $("#successMsg").empty();
                $("#successMsg").append("1f3f23f32fg");
            } else {
                // JavaScript код для отображения ошибок
                var errorMessages = response.errors;

                if (errorMessages) {
                    // Очищаем контейнер от предыдущих ошибок
                    $("#title_error").empty();
                    $("#title_error").append(errorMessages.title);
                    $("#price_error").empty();
                    $("#price_error").append(errorMessages.price_per_click);
                    $("#url_error").empty();
                    $("#url_error").append(errorMessages.url);
                }
            }
        },
    });
});
// });

var currentUrl = window.location.pathname;

// Проверяем, соответствует ли текущий URL шаблонам '/dashboard/*' или '/admin_panel/*'
if (
    currentUrl.match(/^\/dashboard\/.+/) ||
    currentUrl.match(/^\/admin_panel\/.+/)
) {
    // URL соответствует, выполняем функцию buildFirstChart
    buildFirstChart();

    function buildFirstChart() {
        const dataForChart = getDataForChart(combinedData, "day");

        buildChart(
            dataForChart.dateArray,
            dataForChart.clicksData,
            dataForChart.spendsData,
            "day"
        );
    }

    // формируем данные для графика

    function getDataForChart(combinedData, grupeByOption) {
        // Исходные данные
        const filledData = {};

        // Найти самую раннюю и финальную дату
        const dateArray = Object.keys(combinedData).sort();
        const minDate = new Date(dateArray[0]);

        const endDate = new Date();
        // const endDate = new Date(dateArray[dateArray.length - 1]); // последняя дата из массива

        for (
            let currentDate = minDate;
            currentDate <= endDate;
            currentDate.setDate(currentDate.getDate() + 1)
        ) {
            const formattedDate = formatDate(currentDate, grupeByOption);
            if (combinedData[formattedDate]) {
                filledData[formattedDate] = combinedData[formattedDate];
            } else {
                filledData[formattedDate] = { clicks: 0, spends: 0 };
                dateArray.push(formattedDate);
            }
            // clicksData.push(filledData[formattedDate].clicks);
            // spendsData.push(filledData[formattedDate].spends);
        }
        dateArray.sort();

        // Создайте массивы для числа кликов и суммы расходов
        const clicksData = Object.values(filledData).map((item) => item.clicks);
        const spendsData = Object.values(filledData).map((item) => item.spends);

        // filledData теперь содержит все даты в заданном диапазоне с нулевыми значениями для недостающих дат

        return {
            dateArray,
            clicksData,
            spendsData,
        };
    }
    // СТРОИМ ГРАФИК
    function buildChart(dateArray, clicksData, spendsData, grupeByOption) {
        // Получение элемента canvas для графика
        const canvas = document.getElementById("myChart");

        const ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        let data = {
            labels: dateArray,
            datasets: [
                {
                    label: "Клики",
                    data: clicksData,
                    yAxisID: "y",
                    backgroundColor: "rgba(153, 153, 153, 0.4)",
                    borderColor: "rgba(153, 153, 153, 1)",
                },
                {
                    label: "Расходы",
                    data: spendsData,
                    type: "line",
                    pointStyle: false,
                    borderWidth: 1.8,
                    yAxisID: "y1",
                    tension: 0.2,
                    fill: true,
                    backgroundColor: "rgba(255, 134, 134, 0.5)",
                    borderColor: "rgba(255, 134, 134, 1)",
                },
            ],
        };

        let xScaleConfig = {
            type: "time",
            time: {
                unit: grupeByOption,
                minRange: 30,
                maxRange: 400,
            },
            ticks: {
                display: true,
                autoSkip: true,
                maxRotation: 0,
                // color: "rgb (74,169,230,0.9)",
            },
            // min: 0,
            // max: 50,
            border: {
                // color: "#9BD0F5",
            },
        };
        let yScaleConfig = {
            type: "linear",
            position: "left",
            min: 0,
            ticks: {
                stepSize: 1, // Устанавливаем шаг 1, чтобы отображать только целые числа
            },
        };
        let y1ScaleConfig = {
            position: "right",
            grid: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
            },
        };

        let zoomoptions = {
            limits: {
                x: {
                    min: 0,
                    // max: 600,
                    minRange: 30,
                    maxRange: 400,
                },
            },
            pan: {
                enabled: true,
                mode: "x",
            },
            zoom: {
                mode: "x",
                pinch: {
                    enabled: true,
                },
                wheel: {
                    enabled: true,
                    speed: 0.01,
                },
            },
        };

        let config = {
            type: "bar",
            data: data,
            options: {
                responsive: true,
                interaction: {
                    mode: "index",
                    intersect: false,
                },
                stacked: false,
                scales: {
                    x: xScaleConfig,
                    y: yScaleConfig,
                    y1: y1ScaleConfig,
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    zoom: zoomoptions,
                },
            },
        };

        chart = new Chart(ctx, config);
    }

    function updateChart(dataForChart, grupeByOption) {
        chart.config.options.scales.x.time.unit = grupeByOption;
        chart.config.data.labels = dataForChart.dateArray;
        chart.config.data.datasets[0].data = dataForChart.clicksData;
        chart.config.data.datasets[1].data = dataForChart.spendsData;
        chart.update();
    }
    document.getElementById("groupByDays").addEventListener("click", () => {
        let grupeByOption = "day";
        const groupedData = groupData(combinedData, grupeByOption);

        const dataForChart = getDataForChart(groupedData, grupeByOption);
        updateChart(dataForChart, grupeByOption);
    });

    document.getElementById("groupByMonths").addEventListener("click", () => {
        let grupeByOption = "month";
        const groupedData = groupData(combinedData, grupeByOption);

        const dataForChart = getDataForChart(groupedData, grupeByOption);

        updateChart(dataForChart, grupeByOption);
    });

    document.getElementById("groupByYears").addEventListener("click", () => {
        let grupeByOption = "year";
        const groupedData = groupData(combinedData, grupeByOption);

        const dataForChart = getDataForChart(groupedData, grupeByOption);
        updateChart(dataForChart, grupeByOption);
    });

    function groupData(data, groupByOption) {
        const groupedData = {};
        for (const date in data) {
            let dateToFormat = new Date(date);
            const key = formatDate(dateToFormat, groupByOption);

            if (!groupedData[key]) {
                groupedData[key] = { clicks: 0, spends: 0 };
            }
            groupedData[key].clicks += data[date].clicks;
            groupedData[key].spends += data[date].spends;
        }
        return groupedData;
    }

    function formatDate(date, grupeByOption) {
        let dateString = date.toISOString();

        if (grupeByOption === "month") {
            return dateString.slice(0, 7);
        } else if (grupeByOption === "year") {
            return dateString.slice(0, 4);
        }

        return dateString.split("T")[0];
    }
}
