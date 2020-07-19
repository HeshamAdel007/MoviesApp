<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name'              => 'Hesham Adel',
            'email'             => 'hesham@adel.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('0123456789'),
        ]);

        $user->attachRole('owner');
        $rol_str = ['users', 'post', 'category', 'tags', 'actor'];
        $perm_str = ['create', 'read', 'update', 'delete'];
        foreach ($rol_str as $rol) {
            foreach ($perm_str as $perm) {
                $user->attachPermissions([
                    $perm . '_' . $rol,
                ]);
            };
        };
        $user->attachPermissions([
            'read_setting',
            'update_setting',
            'read_profile',
            'update_profile',
        ]);
    }
}
