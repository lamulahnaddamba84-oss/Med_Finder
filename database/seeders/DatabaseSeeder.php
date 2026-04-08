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
        $admin = User::firstOrCreate(
            ['email' => 'admin@medfinder.test'],
            ['name' => 'MedFinder Admin', 'password' => 'password', 'role' => 'admin']
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@medfinder.test'],
            ['name' => 'Amina Njeri', 'password' => 'password', 'role' => 'user']
        );

        if (! Schema::hasTable('pharmacies') || ! Schema::hasTable('medicines') || ! Schema::hasTable('reservations')) {
            return;
        }

        $pharmacyOwners = User::factory(3)->create(['role' => 'pharmacy']);

        $pharmacies = collect([
            [
                'user_id' => $pharmacyOwners[0]->id,
                'name' => 'CityCare Pharmacy',
                'city' => 'Nairobi',
                'address' => 'Kenyatta Avenue',
                'phone' => '+254700111111',
                'status' => 'approved',
                'is_subscribed' => true,
                'subscription_plan' => 'Premium',
                'subscribed_at' => now()->subDays(12),
            ],
            [
                'user_id' => $pharmacyOwners[1]->id,
                'name' => 'Westlands Health Chemist',
                'city' => 'Nairobi',
                'address' => 'Westlands Road',
                'phone' => '+254700222222',
                'status' => 'approved',
                'is_subscribed' => true,
                'subscription_plan' => 'Standard',
                'subscribed_at' => now()->subDays(4),
            ],
            [
                'user_id' => $pharmacyOwners[2]->id,
                'name' => 'MediQuick Pharmacy',
                'city' => 'Kiambu',
                'address' => 'Kiambu Road',
                'phone' => '+254700333333',
                'status' => 'pending',
                'is_subscribed' => false,
                'subscription_plan' => null,
                'subscribed_at' => null,
            ],
        ])->map(fn (array $pharmacy) => Pharmacy::firstOrCreate(['name' => $pharmacy['name']], $pharmacy));

        $medicines = collect([
            ['pharmacy_id' => $pharmacies[0]->id, 'name' => 'Panadol', 'category' => 'Pain Relief', 'form' => 'Tablet', 'strength' => '500mg', 'price' => 120, 'stock' => 40, 'status' => 'available'],
            ['pharmacy_id' => $pharmacies[0]->id, 'name' => 'Amoxicillin', 'category' => 'Antibiotic', 'form' => 'Capsule', 'strength' => '250mg', 'price' => 380, 'stock' => 16, 'status' => 'available'],
            ['pharmacy_id' => $pharmacies[1]->id, 'name' => 'Ventolin', 'category' => 'Respiratory', 'form' => 'Inhaler', 'strength' => '100mcg', 'price' => 850, 'stock' => 8, 'status' => 'available'],
            ['pharmacy_id' => $pharmacies[1]->id, 'name' => 'Cetirizine', 'category' => 'Allergy', 'form' => 'Tablet', 'strength' => '10mg', 'price' => 210, 'stock' => 22, 'status' => 'available'],
            ['pharmacy_id' => $pharmacies[2]->id, 'name' => 'Metformin', 'category' => 'Diabetes', 'form' => 'Tablet', 'strength' => '500mg', 'price' => 460, 'stock' => 0, 'status' => 'out_of_stock'],
        ])->map(fn (array $medicine) => Medicine::firstOrCreate([
            'pharmacy_id' => $medicine['pharmacy_id'],
            'name' => $medicine['name'],
        ], $medicine));

        Reservation::firstOrCreate([
            'user_id' => $customer->id,
            'pharmacy_id' => $pharmacies[0]->id,
            'medicine_id' => $medicines[0]->id,
        ], [
            'quantity' => 2,
            'status' => 'confirmed',
            'reserved_for' => now()->addDay(),
            'notes' => 'Customer requested evening pickup.',
        ]);

        Reservation::firstOrCreate([
            'user_id' => $customer->id,
            'pharmacy_id' => $pharmacies[1]->id,
            'medicine_id' => $medicines[2]->id,
        ], [
            'quantity' => 1,
            'status' => 'pending',
            'reserved_for' => now()->addDays(2),
            'notes' => 'Needs confirmation from pharmacist.',
        ]);
    }
}
