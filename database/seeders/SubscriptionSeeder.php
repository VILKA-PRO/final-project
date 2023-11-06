<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'unique_url' => 'https://example.com/travel-europe',
                'user_id' => 1, // Замените на существующий user_id
                'offer_id' => 1, // Замените на существующий offer_id
                'clicks' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unique_url' => 'https://example.com/pasta-recipes',
                'user_id' => 2, // Замените на существующий user_id
                'offer_id' => 2, // Замените на существующий offer_id
                'clicks' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unique_url' => 'https://example.com/sports-gear',
                'user_id' => 3, // Замените на существующий user_id
                'offer_id' => 1, // Замените на существующий offer_id
                'clicks' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unique_url' => 'https://example.com/art-culture',
                'user_id' => 2, // Замените на существующий user_id
                'offer_id' => 3, // Замените на существующий offer_id
                'clicks' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unique_url' => 'https://example.com/family-blog',
                'user_id' => 1, // Замените на существующий user_id
                'offer_id' => 4, // Замените на существующий offer_id
                'clicks' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
