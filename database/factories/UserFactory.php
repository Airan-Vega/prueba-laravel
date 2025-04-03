<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->userName(),
            'dni' => $this->generateDNI(),
        ];
    }

    private function generateDNI()
    {

        $numbers = $this->faker->unique()->numerify('#########');

        $letter = $this->calculateDNILetter($numbers);
        return $numbers . $letter;
    }

    private function calculateDNILetter($numbers)
    {

        $letters = 'TRWAGMYFPDXBNJZSQVHLCK';
        $remainder = intval($numbers) % 23;
        return $letters[$remainder];
    }
}
