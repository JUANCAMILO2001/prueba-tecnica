<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ciudad;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        $username = Str::slug($name, '');

        return [
            'document_type' => $this->faker->randomElement(['Cedula Ciudadania', 'Tarjeta de Identidad', 'Pasaporte']),
            'document_number' => $this->faker->unique()->numerify('########'),
            'name' => $name,
            'lastname' => $this->faker->lastName(),
            'birthdate' => $this->faker->date(),
            'city_id' => Ciudad::all()->random()->id,
            'username' => $username,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
