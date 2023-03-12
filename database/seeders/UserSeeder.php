<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'imasnurdianto2002@gmail.com',
            'name' => 'Imas Nurdianto',
            'password' => Hash::make('tes'),
        ]);
        User::create([
            'email' => 'nurdianto3421@gmail.com',
            'name' => 'Nurdianto',
            'password' => Hash::make('tes'),
        ]);
    }
}
