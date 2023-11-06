<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Click;


class ClickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Получаем все записи из таблицы clicks
        $clicks = Click::all();

        // Перебираем каждую запись и устанавливаем случайное значение для click_cost
        $clicks->each(function ($click) {
            $click->click_cost = number_format(mt_rand(1, 100) / 100, 2); // Генерируем случайное значение от 0.01 до 1.00
            $click->save(); // Сохраняем изменения
        });
    }
}
