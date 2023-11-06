<?php

namespace Database\Factories;

use App\Models\Click;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Click>
 */
class ClickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::now()->subYear()->addSeconds(rand(0, 31536000));

        return [
            'subscription_id' => $this->faker->numberBetween(1, 5), // ID подписок от 1 до 5
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
