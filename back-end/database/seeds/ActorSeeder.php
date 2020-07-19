<?php

use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $actor = \App\Actor::create([
            "name"         => "Movies App",
            "description"  => "movies-app",
        ]);
    }
}
