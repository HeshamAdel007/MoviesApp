<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = \App\Setting::create([
            "name"        => "Movies App",
            "email"       => "moviesapp@info.com",
            "adress"      => "Egypt,Alex",
            "description" => "writing Something Smart",
            "facebook"    => "Hesham.H.Adel",
            "twitter"     => "H_Adel5",
            "instagram"   => "h_adel0",
            "youtube"     => "UCPzB16fs2IIFH_oVDT3F5kw",
        ]);

    }
}
