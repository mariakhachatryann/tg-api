<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_id' => $this->faker->numberBetween(10000, 99999),
            'message_id' => $this->faker->numberBetween(10000, 99999),
            'user_id' => $this->faker->numberBetween(10000, 99999),
            'date' => 1738843825,
            'message' => $this->faker->sentence(),
//            'created_at' => Carbon::createFromTimestamp(1738843825),
//            'updated_at' => Carbon::createFromTimestamp(1738843825),

        ];
    }
}
