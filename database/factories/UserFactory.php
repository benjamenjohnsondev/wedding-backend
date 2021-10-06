<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $totalAttending = $this->faker->numberBetween(1,5);
        $meals = [];

        for ($i = 1; $i <= $totalAttending; $i++) {
            $meals[] = [
                'guest_name' => $this->faker->name(),
                'starter' => $this->faker->numberBetween(1,3),
                'main' => $this->faker->numberBetween(1,3),
                'dessert' => $this->faker->numberBetween(1,3)
            ];
        }

        return [
            'party_name' => $this->faker->name(),
            'greeting_name' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('test123'),
            'rsvp' => $this->faker->boolean(85),
            'plus_one' => $this->faker->boolean(),
            'expected_attending' => $this->faker->numberBetween(1,10),
            'total_attending' => $totalAttending,
            'meal_choice' => (string) json_encode($meals),
            'song_recommendations' => implode(' ', $this->faker->words(2)),
            'remember_token' => Str::random(10),
        ];
    }
}
