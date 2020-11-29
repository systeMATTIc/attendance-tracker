<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
    public function definition()
    {
        return [
            "uuid" => $this->faker->uuid,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            "is_admin" => $this->faker->boolean(10),
            "travel_type_id" => $this->faker->numberBetween(1, 4),
            "distance_from_home" => function (array $attributes) {
                if ($attributes["travel_type_id"] == 3) {
                    return $this->faker->numberBetween(1, 5);
                }

                return $this->faker->numberBetween(11, 20);
            }
        ];
    }
}
