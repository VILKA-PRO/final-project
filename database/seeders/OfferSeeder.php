<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('offers')->insert([
            [
                'title' => 'Путешествие в Европу',
                'url' => 'https://example.com/travel-europe',
                'price_per_click' => 0.50,
                'user_id' => 1, // Замените на существующий user_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Лучшие рецепты пасты',
                'url' => 'https://example.com/pasta-recipes',
                'price_per_click' => 0.75,
                'user_id' => 2, // Замените на существующий user_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Спортивное оборудование',
                'url' => 'https://example.com/sports-gear',
                'price_per_click' => 0.60,
                'user_id' => 1, // Замените на существующий user_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Искусство и культура мира',
                'url' => 'https://example.com/art-culture',
                'price_per_click' => 0.80,
                'user_id' => 3, // Замените на существующий user_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Семейный блог',
                'url' => 'https://example.com/family-blog',
                'price_per_click' => 0.70,
                'user_id' => 2, // Замените на существующий user_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
