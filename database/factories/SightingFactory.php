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
        // Title prefix
        $prefix = [
            'Abducted by aliens in',
            'Beamed up into alien ship in',
            'Beams of light over',
            'Bizarre dreams while staying in',
            'Close encounter in',
            'Flash of light in the sky over',
            'Hovering over house in',
            'Landed in backyard in',
            'UFO sighting in',
            'Unidentified life form spotted in'
        ];

        // Date
        $date = Carbon::instance(
            $this->faker->dateTimeBetween(
                '-10 years', 'today'
            )
        );

        // State
        $states = [
            'Utah',
            'Wyoming',
            'Colorado'
        ];
        $state = Arr::random($states);

        // Location coordinates
        switch ($state) {
            case 'Utah':
                $min_lat = 37.008065;
                $max_lat = 41.981231;
                $min_lng = -111.058133;
                $max_lng = -114.027189;
                break;
            case 'Wyoming':
                $min_lat = 41.007221;
                $max_lat = 44.968645;
                $min_lng = -104.090055;
                $max_lng = -111.025174;
                break;
            case 'Colorado':
                $min_lat = 37.005726;
                $max_lat = 40.976539;
                $min_lng = -102.06857;
                $max_lng = -109.031156;
                break;
            default:
                $min_lat = 35;
                $max_lat = 45;
                $min_lng = -90;
                $max_lng = -120;
        }

        return [
            'id' => Str::uuid(),
            'title' => Arr::random($prefix) . ' ' . $this->faker->city . ', ' . $state,
            'date' => $date,
            'description' => $this->faker->text(),
            'location' => $this->faker->latitude($min_lat, $max_lat)
                . ',' . $this->faker->longitude($min_lng, $max_lng),
            'state' => $state,
            'img_path' => random_int(0, 1) ? './images/user/640x480.png' : null,
        ];
    }
}
