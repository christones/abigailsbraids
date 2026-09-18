<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Http\Requests\StoreBookingRequest;
use App\Mail\BookingConfirmation;
use App\Mail\NewBookingNotification;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Support\BookingSlots;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BookingController extends Controller
{
    use HandlesImageUploads;

    /**
     * Show the booking form.
     */
    public function create(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['options' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->get();

        $optionsByService = $services->mapWithKeys(function (Service $service) {
            $groups = $service->options
                ->groupBy('group_label')
                ->map(fn ($options) => $options->map(fn (ServiceOption $option) => [
                    'id' => $option->id,
                    'label' => $option->value_label,
                    'price' => $option->extra_price !== null ? (float) $option->extra_price : 0,
                ])->values())
                ->map(fn ($options, $groupLabel) => [
                    'group' => $groupLabel,
                    'options' => $options,
                ])
                ->values();

            return [$service->id => $groups];
        });

        $priceFromByService = $services->mapWithKeys(fn (Service $service) => [
            $service->id => (float) $service->price_from,
        ]);

        $selectedServiceId = request()->integer('prestation') ?: null;

        return view('booking.create', [
            'services' => $services,
            'slots' => BookingSlots::all(),
            'selectedServiceId' => $selectedServiceId,
            'preselectedService' => $selectedServiceId ? $services->firstWhere('id', $selectedServiceId) : null,
            'optionsByService' => $optionsByService,
            'priceFromByService' => $priceFromByService,
        ]);
    }

    /**
     * Store a new booking request.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['hair_photo', 'inspiration_photo', 'option_choices', 'option_other']);

        if ($request->hasFile('hair_photo')) {
            $data['hair_photo_path'] = $this->storeUploadedImage($request->file('hair_photo'), 'bookings');
        }

        if ($request->hasFile('inspiration_photo')) {
            $data['inspiration_photo_path'] = $this->storeUploadedImage($request->file('inspiration_photo'), 'bookings');
        }

        $service = Service::findOrFail((int) $request->input('service_id'));

        ['snapshot' => $data['selected_options'], 'extra_total' => $extraTotal] = $this->resolveSelectedOptions(
            $service->id,
            $request->input('option_choices', []),
            $request->input('option_other', [])
        );

        $data['estimated_price'] = round((float) $service->price_from + $extraTotal, 2);

        $booking = Booking::create($data);

        $this->sendNotifications($booking);

        return redirect()
            ->route('booking.confirmation', $booking)
            ->with('success', true);
    }

    /**
     * Show the confirmation page for a booking.
     */
    public function confirmation(Booking $booking): View
    {
        $booking->load('service');

        return view('booking.confirmation', [
            'booking' => $booking,
        ]);
    }

    /**
     * Turn the submitted option choices into a readable snapshot, so it stays
     * accurate even if the option catalogue changes later, and sum up any
     * extra fees they carry. Falls back to a free-text value (with no fee)
     * when the client picked an "Autre..." choice.
     *
     * @param  array<string, mixed>  $optionChoices
     * @param  array<string, mixed>  $optionOther
     * @return array{snapshot: array<int, array{group: string, value: string}>|null, extra_total: float}
     */
    private function resolveSelectedOptions(int $serviceId, array $optionChoices, array $optionOther): array
    {
        if (empty($optionChoices)) {
            return ['snapshot' => null, 'extra_total' => 0.0];
        }

        $optionIds = array_filter(array_map('intval', $optionChoices));

        if (empty($optionIds)) {
            return ['snapshot' => null, 'extra_total' => 0.0];
        }

        $options = ServiceOption::query()
            ->whereIn('id', $optionIds)
            ->where('service_id', $serviceId)
            ->get()
            ->keyBy('id');

        $selected = [];
        $extraTotal = 0.0;

        foreach ($optionChoices as $groupKey => $optionId) {
            $option = $options->get((int) $optionId);

            if (! $option) {
                continue;
            }

            $value = $option->value_label;

            if (str_starts_with(mb_strtolower($value), 'autre') && filled($optionOther[$groupKey] ?? null)) {
                $value = trim($optionOther[$groupKey]);
            }

            $selected[] = [
                'group' => $option->group_label,
                'value' => $value,
            ];

            $extraTotal += (float) ($option->extra_price ?? 0);
        }

        return [
            'snapshot' => $selected === [] ? null : $selected,
            'extra_total' => $extraTotal,
        ];
    }

    /**
     * Email the salon and the client about the new booking.
     */
    private function sendNotifications(Booking $booking): void
    {
        try {
            Mail::to(config('salon.notification_email'))
                ->send(new NewBookingNotification($booking));
        } catch (\Throwable $e) {
            Log::error('Failed to send new booking notification email.', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            Mail::to($booking->client_email)
                ->send(new BookingConfirmation($booking));
        } catch (\Throwable $e) {
            Log::error('Failed to send booking confirmation email to client.', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
