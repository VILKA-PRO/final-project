<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $topics = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10 // Предположим, у вас есть 10 разных тематик с id
    ];

    $offers = [
        1, 2, 3, 4, 5 // Предположим, у вас есть 5 разных предложений с id
    ];

    foreach ($offers as $offerId) {
        // Для каждого предложения случайным образом выбираем одну из тематик
        $topicId = $topics[array_rand($topics)];

        DB::table('offer_topics')->insert([
            'offer_id' => $offerId,
            'topic_id' => $topicId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

}
