<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
{
    \App\Models\User::firstOrCreate(
        ['email' => 'admin@medfinder.test'],
        [
            'name' => 'MedFinder Admin',
            // bcrypt handles the encryption Laravel requires
            'password' => bcrypt('admin@123'), 
            'role' => 'admin'
        ]
    );
}
}
