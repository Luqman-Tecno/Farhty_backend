<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\WeddingHall;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'booking_date' => Carbon::now(),
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now(),
            'total_cost' => $this->faker->randomFloat(),
            'deposit_paid' => $this->faker->randomFloat(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'wedding_hall_id' => WeddingHall::factory(),
        ];
    }
}
