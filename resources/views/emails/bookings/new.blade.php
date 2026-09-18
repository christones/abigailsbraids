@extends('emails.layout')

@section('subject', 'Nouvelle demande de réservation')
@section('footer_note', "Cet e-mail a été généré automatiquement suite à une demande de réservation en ligne.")

@section('content')
    {{-- Title --}}
    <tr>
        <td style="padding:32px 32px 8px;">
            <p style="margin:0; color:#a95524; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px;">
                Nouvelle demande
            </p>
            <h1 style="margin:6px 0 0; color:#221812; font-size:24px;">
                Réservation reçue
            </h1>
            <p style="margin:12px 0 0; color:#5f2c17; font-size:14px; line-height:1.6;">
                {{ $booking->client_name }} vient de demander un rendez-vous. Voici le récapitulatif :
            </p>
        </td>
    </tr>

    {{-- Details card --}}
    <tr>
        <td style="padding:16px 32px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fdf6f0; border-radius:12px;">
                <tr>
                    <td style="padding:20px 24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#221812;">
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; width:140px; vertical-align:top;">Prestation</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $booking->service->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Date souhaitée</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $booking->preferred_date->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Créneau</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $booking->preferred_time }}</td>
                            </tr>
                            @if ($booking->selected_options)
                                @foreach ($booking->selected_options as $selection)
                                    <tr>
                                        <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">{{ $selection['group'] }}</td>
                                        <td style="padding:6px 0; font-weight:bold;">{{ $selection['value'] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Cliente</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $booking->client_name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Téléphone</td>
                                <td style="padding:6px 0;"><a href="tel:{{ $booking->client_phone }}" style="color:#a95524; text-decoration:none; font-weight:bold;">{{ $booking->client_phone }}</a></td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">E-mail</td>
                                <td style="padding:6px 0;"><a href="mailto:{{ $booking->client_email }}" style="color:#a95524; text-decoration:none; font-weight:bold;">{{ $booking->client_email }}</a></td>
                            </tr>
                            @if ($booking->notes)
                                <tr>
                                    <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Message</td>
                                    <td style="padding:6px 0;">{{ $booking->notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if ($booking->hair_photo_path || $booking->inspiration_photo_path)
        {{-- Client photos --}}
        <tr>
            <td style="padding:0 32px 8px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        @if ($booking->hair_photo_path)
                            <td style="padding:8px; width:50%; vertical-align:top;">
                                <p style="margin:0 0 6px; color:#5f2c17; font-size:12px; font-weight:bold; text-transform:uppercase;">Cheveux actuels</p>
                                <img
                                    src="{{ $message->embed(public_path($booking->hair_photo_path)) }}"
                                    alt="Photo des cheveux actuels de {{ $booking->client_name }}"
                                    width="260"
                                    style="display:block; max-width:100%; border-radius:12px;"
                                >
                            </td>
                        @endif
                        @if ($booking->inspiration_photo_path)
                            <td style="padding:8px; width:50%; vertical-align:top;">
                                <p style="margin:0 0 6px; color:#5f2c17; font-size:12px; font-weight:bold; text-transform:uppercase;">Modèle souhaité</p>
                                <img
                                    src="{{ $message->embed(public_path($booking->inspiration_photo_path)) }}"
                                    alt="Modèle souhaité par {{ $booking->client_name }}"
                                    width="260"
                                    style="display:block; max-width:100%; border-radius:12px;"
                                >
                            </td>
                        @endif
                    </tr>
                </table>
            </td>
        </tr>
    @endif

    {{-- CTA --}}
    <tr>
        <td style="padding:8px 32px 32px; text-align:center;">
            <a
                href="{{ route('admin.dashboard') }}"
                style="display:inline-block; background-color:#a95524; color:#ffffff; text-decoration:none; font-family:Arial, sans-serif; font-size:14px; font-weight:bold; padding:14px 28px; border-radius:999px;"
            >
                Voir dans l'espace salon
            </a>
        </td>
    </tr>
@endsection
