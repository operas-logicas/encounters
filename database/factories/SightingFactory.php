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
            'Beamed up into alien ship in',
            'Beams of light over',
            'Bizarre dreams while in',
            'Bright lights over',
            'Encounter in',
            'Flash of light over',
            'Experimented on in',
            'Probed in',
            'Sighting in'
        ];

        $state = $this->faker->state;

        $date = Carbon::instance(
            $this->faker->dateTimeBetween(
                '-10 years', 'today'
            )
        );

        return [
            'id' => Str::uuid(),
            'title' => Arr::random($prefix) . ' ' . $this->faker->city . ', ' . $state,
            'date' => $date,
            'description' => $this->faker->text(),
            'location' => $this->faker->latitude . ',' . $this->faker->longitude,
            'state' => $state,
            'img_path' => random_int(0, 1) ? './images/user/640x480.png' : null,
        ];
    }
}
