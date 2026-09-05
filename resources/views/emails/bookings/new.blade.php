<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle demande de réservation</title>
</head>
<body style="margin:0; padding:0; background-color:#f7f5f3; font-family:Georgia, 'Times New Roman', serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f7f5f3; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(34,24,18,0.08);">

                    {{-- Header / branding --}}
                    <tr>
                        <td style="background-color:#a95524; padding:28px 32px; text-align:center;">
                            <img
                                src="{{ $message->embed(public_path('images/logoAbi.jpg')) }}"
                                alt="Logo Abigail's Braids"
                                width="64"
                                height="64"
                                style="display:block; margin:0 auto 12px; border-radius:50%; border:3px solid #fdf6f0;"
                            >
                            <div style="color:#ffffff; font-size:22px; font-weight:bold; letter-spacing:0.5px;">
                                Abigail's Braids
                            </div>
                            <div style="color:#f3d1ae; font-size:12px; text-transform:uppercase; letter-spacing:2px; margin-top:4px;">
                                Salon de tresses &amp; nattes africaines &middot; Strasbourg
                            </div>
                        </td>
                    </tr>

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
                                            @if ($booking->hair_length)
                                                <tr>
                                                    <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Longueur de cheveux</td>
                                                    <td style="padding:6px 0; font-weight:bold;">{{ $booking->hair_length }}</td>
                                                </tr>
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

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px; border-top:1px solid #f3d1ae; text-align:center;">
                            <p style="margin:0; color:#221812; opacity:0.5; font-size:12px; font-family:Arial, sans-serif;">
                                Abigail's Braids &middot; Strasbourg, France
                            </p>
                            <p style="margin:4px 0 0; color:#221812; opacity:0.4; font-size:11px; font-family:Arial, sans-serif;">
                                Cet e-mail a été généré automatiquement suite à une demande de réservation en ligne.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
