<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PharmacySeeder::class,
            MedicineSeeder::class,

        ]);
        $admin = User::firstOrCreate(
            ['email' => 'admin@medfinder.test'],
            ['name' => 'MedFinder Admin', 'password' => bcrypt('admin@123'), 'role' => 'admin']
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@medfinder.test'],
            ['name' => 'Amina Njeri', 'password' => 'password', 'role' => 'user']
        );

        if (! Schema::hasTable('pharmacies') || ! Schema::hasTable('medicines') || ! Schema::hasTable('reservations')) {
            return;
        }

        
    }
}
