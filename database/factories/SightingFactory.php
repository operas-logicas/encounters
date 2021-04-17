<?php

namespace Database\Factories;

use App\Models\Sighting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SightingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sighting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $prefix = [
            'Abducted in',
            'Beamed up in',
            'Beams of light in',
            'Bizarre dreams while in',
            'Bright lights in',
            'Encounter in',
            'Experimented on in',
            'Probed in',
            'Sighting in'
        ];

        $date = Carbon::instance(
            $this->faker->dateTimeBetween(
                '-10 years', 'today'
            )
        );

        return [
            'id' => Str::uuid(),
            'title' => Arr::random($prefix) . ' ' . $this->faker->city . ', ' . $this->faker->state,
            'date' => $date,
            'description' => $this->faker->text(),
            'location' => $this->faker->latitude . ', ' . $this->faker->longitude,
            'img_path' => random_int(0, 1) ? './images/user/640x480.png' : null,
        ];
    }
}
