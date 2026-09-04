<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_bookings(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $booking = Booking::factory()->for($service)->create();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee($booking->client_name);
    }

    public function test_authenticated_user_can_update_booking_status(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();
        $booking = Booking::factory()->for($service)->create(['status' => Booking::STATUS_PENDING]);

        $response = $this->actingAs($user)->patch(route('admin.bookings.update', $booking), [
            'status' => Booking::STATUS_CONFIRMED,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => Booking::STATUS_CONFIRMED,
        ]);
    }

    public function test_login_requires_correct_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
