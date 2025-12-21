<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'fname' => 'abaca',
            'lname' => 'admin',
            'username' => 'abaca.admin',
            'password' => Hash::make('adminpassword'),
            'brgy' => 'sample brgy',
            'role' => 1
        ]);

        User::create([
            'fname' => 'abaca',
            'lname' => 'expert',
            'username' => 'abaca.expert',
            'username' => 'expert',
            'password' => Hash::make('expertpassword'),
            'brgy' => 'sample brgy',
            'role' => 2
        ]);

        User::create([
            'fname' => 'abaca',
            'lname' => 'user',
            'username' => 'abaca.user',
            'username' => 'user',
            'password' => Hash::make('userpassword'),
            'brgy' => 'sample brgy',
            'role' => 3
        ]);
    }
}
