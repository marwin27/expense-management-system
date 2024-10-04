<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to import your User model
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('email', 'abaquinmarwinc@gmail.com')->exists()) {
            User::create([
                'name' => 'Abaquin Marwin C.',
                'email' => 'abaquinmarwinc@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Admin', 
            ]);
        }
    }
}
