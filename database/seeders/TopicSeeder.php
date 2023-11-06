<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $topics = [
        'Автомобили',
        'Технологии',
        'Здоровье и фитнес',
        'Кулинария и рецепты',
        'Путешествия',
        'Спорт и фитнес',
        'Мода и стиль',
        'Финансы и инвестиции',
        'Искусство и культура',
        'Дом и семья',
    ];

    foreach ($topics as $topic) {
        DB::table('topics')->insert([
            'topic' => $topic,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

}
