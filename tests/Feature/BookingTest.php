<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmation;
use App\Mail\NewBookingNotification;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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

    public function test_booking_page_preselects_the_chosen_service(): void
    {
        $chosen = Service::factory()->create(['is_active' => true, 'name' => 'Box Braids']);
        $other = Service::factory()->create(['is_active' => true, 'name' => 'Vanilles']);

        $response = $this->get(route('booking.create', ['prestation' => $chosen->id]));

        $response->assertOk();
        $response->assertSee('Prestation choisie');
        $response->assertSee($chosen->name);
        $response->assertSee('value="'.$chosen->id.'"', false);
        $response->assertDontSee('-- Choisissez une prestation --');
    }

    public function test_booking_page_shows_the_dropdown_when_no_service_is_preselected(): void
    {
        $service = Service::factory()->create(['is_active' => true]);

        $response = $this->get(route('booking.create'));

        $response->assertOk();
        $response->assertSee('-- Choisissez une prestation --');
        $response->assertDontSee('Prestation choisie');
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

    public function test_a_client_can_upload_hair_and_inspiration_photos(): void
    {
        $service = Service::factory()->create();

        $response = $this->post(route('booking.store'), [
            'service_id' => $service->id,
            'client_name' => 'Fatoumata Diallo',
            'client_email' => 'fatou@example.com',
            'client_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'preferred_time' => '10:30',
            'hair_photo' => UploadedFile::fake()->create('cheveux.jpg', 100, 'image/jpeg'),
            'inspiration_photo' => UploadedFile::fake()->create('pinterest.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect();

        $booking = Booking::firstWhere('client_email', 'fatou@example.com');

        $this->assertNotNull($booking->hair_photo_path);
        $this->assertNotNull($booking->inspiration_photo_path);
        $this->assertFileExists(public_path($booking->hair_photo_path));
        $this->assertFileExists(public_path($booking->inspiration_photo_path));
    }

    public function test_selected_options_are_stored_as_a_readable_snapshot(): void
    {
        $service = Service::factory()->create();
        $model = ServiceOption::factory()->for($service)->create(['group_label' => 'Modèle', 'value_label' => '4 tresses']);
        $color = ServiceOption::factory()->for($service)->create(['group_label' => 'Couleur', 'value_label' => 'Autre couleur']);

        $otherService = Service::factory()->create();
        $foreignOption = ServiceOption::factory()->for($otherService)->create();

        $response = $this->post(route('booking.store'), [
            'service_id' => $service->id,
            'client_name' => 'Fatoumata Diallo',
            'client_email' => 'fatou@example.com',
            'client_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'preferred_time' => '10:30',
            'option_choices' => [
                'Modèle' => $model->id,
                'Couleur' => $color->id,
                'Ignoré' => $foreignOption->id,
            ],
            'option_other' => [
                'Couleur' => 'Turquoise',
            ],
        ]);

        $response->assertRedirect();

        $booking = Booking::firstWhere('client_email', 'fatou@example.com');

        $this->assertSame([
            ['group' => 'Modèle', 'value' => '4 tresses'],
            ['group' => 'Couleur', 'value' => 'Turquoise'],
        ], $booking->selected_options);
    }

    public function test_estimated_price_matches_the_service_base_price_without_options(): void
    {
        $service = Service::factory()->create(['price_from' => 90]);

        $this->post(route('booking.store'), [
            'service_id' => $service->id,
            'client_name' => 'Fatoumata Diallo',
            'client_email' => 'fatou@example.com',
            'client_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'preferred_time' => '10:30',
        ]);

        $booking = Booking::firstWhere('client_email', 'fatou@example.com');

        $this->assertSame('90.00', (string) $booking->estimated_price);
    }

    public function test_estimated_price_adds_up_the_chosen_options_fees(): void
    {
        $service = Service::factory()->create(['price_from' => 90]);
        $withFee = ServiceOption::factory()->for($service)->create(['group_label' => 'Longueur', 'extra_price' => 15]);
        $withoutFee = ServiceOption::factory()->for($service)->create(['group_label' => 'Rajouts', 'extra_price' => null]);

        $this->post(route('booking.store'), [
            'service_id' => $service->id,
            'client_name' => 'Fatoumata Diallo',
            'client_email' => 'fatou@example.com',
            'client_phone' => '0600000000',
            'preferred_date' => now()->addWeek()->toDateString(),
            'preferred_time' => '10:30',
            'option_choices' => [
                'Longueur' => $withFee->id,
                'Rajouts' => $withoutFee->id,
            ],
        ]);

        $booking = Booking::firstWhere('client_email', 'fatou@example.com');

        $this->assertSame('105.00', (string) $booking->estimated_price);
    }

    public function test_booking_page_exposes_prices_for_the_live_estimate(): void
    {
        $service = Service::factory()->create(['price_from' => 90]);
        $option = ServiceOption::factory()->for($service)->create(['extra_price' => 15]);

        $response = $this->get(route('booking.create'));

        $response->assertOk();
        $response->assertSee('window.bookingPriceFromByService', false);
        $response->assertSee((string) $service->id.'":90', false);
        $response->assertSee('"price":15', false);
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

        Mail::assertSent(BookingConfirmation::class, function (BookingConfirmation $mail) use ($booking) {
            return $mail->booking->is($booking)
                && $mail->hasTo('fatou@example.com');
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

    public function test_notification_email_embeds_client_photos_and_options(): void
    {
        $service = Service::factory()->create();
        $booking = Booking::factory()->for($service)->create([
            'hair_photo_path' => 'uploads/bookings/hair-test.jpg',
            'inspiration_photo_path' => 'uploads/bookings/inspiration-test.jpg',
            'selected_options' => [['group' => 'Modèle', 'value' => '4 tresses']],
        ]);

        @mkdir(public_path('uploads/bookings'), 0777, true);
        copy(public_path('images/braids8.jpg'), public_path($booking->hair_photo_path));
        copy(public_path('images/braids8.jpg'), public_path($booking->inspiration_photo_path));

        $html = (new NewBookingNotification($booking))->render();

        $this->assertStringContainsString('Modèle', $html);
        $this->assertStringContainsString('4 tresses', $html);
        $this->assertStringContainsString('Cheveux actuels', $html);
        $this->assertStringContainsString('Modèle souhaité', $html);

        @unlink(public_path($booking->hair_photo_path));
        @unlink(public_path($booking->inspiration_photo_path));
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
