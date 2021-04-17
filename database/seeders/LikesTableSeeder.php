<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Sighting;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sighting::all()->each(function (Sighting $sighting) {
            $likes = random_int(0, 15);
            if ($likes === 0) {
                return;
            }

            for ($i = 0; $i < $likes; $i++) {
                $user = User::all()->random();

                $like = Like::make();
                $like->sighting = $sighting->id;
                $like->user = $user->id;

                $like->save();
            }
        });
    }
}
