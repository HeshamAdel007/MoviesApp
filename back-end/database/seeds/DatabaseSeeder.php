<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ActorSeeder::class,
            PostSeeder::class,
            SettingSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
