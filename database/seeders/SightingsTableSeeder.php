<?php

namespace Database\Seeders;

use App\Models\Sighting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SightingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            $sighting = Sighting::factory(random_int(0, 3))->make();
            $user->sightings()->saveMany($sighting);
        });
    }
}
