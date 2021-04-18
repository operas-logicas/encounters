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

            for ($i = 0; $i < $likes; $i++) {
                $user = User::all()->random();

                $like = Like::make();
                $like->sighting_id = $sighting->id;
                $like->user_id = $user->id;

                $like->save();
            }
        });
    }
}
