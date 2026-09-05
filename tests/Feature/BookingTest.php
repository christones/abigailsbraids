<?php

namespace Tests\Feature;

use App\Mail\NewBookingNotification;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_page_lists_active_services(): void
    {
        $service = Service::factory()->create(['is_active' => true]);
        Service::factory()->create(['is_active' => false]);

        $response = $this->get(route('booking.create'));

        $response->assertOk();
        $response->assertSee($service->name);
    }

    public function test_a_client_can_submit_a_booking_request(): void
    {
        $service = Service::factory()->create();

        $payload = [
            'service_id' => $service->id,
            'client_name' => 'Fatoumata Diallo',
            'client_email' => 'fatou@example.com',
            'client_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'preferred_time' => '10:30',
            'hair_length' => 'Longs',
            'notes' => 'Je souhaite un modèle avec raie sur le côté.',
        ];

        $response = $this->post(route('booking.store'), $payload);

        $this->assertDatabaseHas('bookings', [
            'client_email' => 'fatou@example.com',
            'service_id' => $service->id,
            'status' => Booking::STATUS_PENDING,
        ]);

        $booking = Booking::firstWhere('client_email', 'fatou@example.com');

        $response->assertRedirect(route('booking.confirmation', $booking));
    }

    public function test_submitting_a_booking_emails_the_salon(): void
    {
        Mail::fake();

        $service = Service::factory()->create();

        $this->post(route('booking.store'), [
            'service_id' => $service->id,
            'client_name' => 'Fatoumata Diallo',
            'client_email' => 'fatou@example.com',
            'client_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'preferred_time' => '10:30',
        ]);

        $booking = Booking::firstWhere('client_email', 'fatou@example.com');

        Mail::assertSent(NewBookingNotification::class, function (NewBookingNotification $mail) use ($booking) {
            return $mail->booking->is($booking)
                && $mail->hasTo(config('salon.notification_email'));
        });
    }

    public function test_booking_requires_a_valid_service_and_date(): void
    {
        $response = $this->post(route('booking.store'), [
            'client_name' => 'Sans prestation',
            'client_email' => 'invalid-email',
            'client_phone' => '0600000000',
            'preferred_date' => now()->toDateString(), // today is not allowed
            'preferred_time' => '10:30',
        ]);

        $response->assertSessionHasErrors([
            'service_id',
            'client_email',
            'preferred_date',
        ]);

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_confirmation_page_shows_booking_summary(): void
    {
        $service = Service::factory()->create();
        $booking = Booking::factory()->for($service)->create();

        $response = $this->get(route('booking.confirmation', $booking));

        $response->assertOk();
        $response->assertSee($booking->client_name);
        $response->assertSee($service->name);
    }
}
