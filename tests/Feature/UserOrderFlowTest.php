<?php

namespace Tests\Feature;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_place_order_and_reservation_is_saved(): void
    {
        $owner = User::factory()->create(['role' => 'pharmacy']);
        $patient = User::factory()->create(['role' => 'user']);

        $pharmacy = Pharmacy::create([
            'user_id' => $owner->id,
            'name' => 'Kampala Central Pharmacy',
            'city' => 'Kampala',
            'address' => 'Kampala Road',
            'status' => 'approved',
            'is_subscribed' => true,
        ]);

        $medicine = Medicine::create([
            'pharmacy_id' => $pharmacy->id,
            'name' => 'Paracetamol',
            'category' => 'Pain Relief',
            'price' => 200,
            'stock' => 10,
            'status' => 'available',
        ]);

        $this->actingAs($patient)
            ->post(route('user.orders.store'), [
                'medicine_id' => $medicine->id,
                'quantity' => 3,
                'notes' => 'Please keep at the counter.',
            ])
            ->assertRedirect(route('user.dashboard'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('reservations', [
            'user_id' => $patient->id,
            'pharmacy_id' => $pharmacy->id,
            'medicine_id' => $medicine->id,
            'quantity' => 3,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('medicines', [
            'id' => $medicine->id,
            'stock' => 7,
            'status' => 'available',
        ]);
    }

    public function test_user_cannot_order_more_than_available_stock(): void
    {
        $owner = User::factory()->create(['role' => 'pharmacy']);
        $patient = User::factory()->create(['role' => 'user']);

        $pharmacy = Pharmacy::create([
            'user_id' => $owner->id,
            'name' => 'Nakasero Medics',
            'city' => 'Kampala',
            'address' => 'Nakasero Road',
            'status' => 'approved',
            'is_subscribed' => true,
        ]);

        $medicine = Medicine::create([
            'pharmacy_id' => $pharmacy->id,
            'name' => 'Amoxicillin',
            'category' => 'Antibiotic',
            'price' => 500,
            'stock' => 2,
            'status' => 'available',
        ]);

        $this->actingAs($patient)
            ->post(route('user.orders.store'), [
                'medicine_id' => $medicine->id,
                'quantity' => 5,
            ])
            ->assertRedirect(route('user.dashboard'))
            ->assertSessionHasErrors('order');

        $this->assertDatabaseMissing('reservations', [
            'user_id' => $patient->id,
            'medicine_id' => $medicine->id,
            'quantity' => 5,
        ]);
    }
}

