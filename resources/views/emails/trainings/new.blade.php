@extends('emails.layout')

@section('subject', 'Nouvelle inscription formation')
@section('footer_note', "Cet e-mail a été généré automatiquement suite à une inscription à une formation en ligne.")

@section('content')
    {{-- Title --}}
    <tr>
        <td style="padding:32px 32px 8px;">
            <p style="margin:0; color:#a95524; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px;">
                Nouvelle inscription
            </p>
            <h1 style="margin:6px 0 0; color:#221812; font-size:24px;">
                Inscription formation reçue
            </h1>
            <p style="margin:12px 0 0; color:#5f2c17; font-size:14px; line-height:1.6;">
                {{ $registration->candidate_name }} vient de s'inscrire à une formation. Voici le récapitulatif :
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
                                <td style="padding:6px 0; color:#5f2c17; width:140px; vertical-align:top;">Formation</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $registration->training->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Date souhaitée</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $registration->preferred_date->translatedFormat('d F Y') }}</td>
                            </tr>
                            @if ($registration->experience_level)
                                <tr>
                                    <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Niveau</td>
                                    <td style="padding:6px 0; font-weight:bold;">{{ $registration->experience_level }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Candidate</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $registration->candidate_name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Téléphone</td>
                                <td style="padding:6px 0;"><a href="tel:{{ $registration->candidate_phone }}" style="color:#a95524; text-decoration:none; font-weight:bold;">{{ $registration->candidate_phone }}</a></td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">E-mail</td>
                                <td style="padding:6px 0;"><a href="mailto:{{ $registration->candidate_email }}" style="color:#a95524; text-decoration:none; font-weight:bold;">{{ $registration->candidate_email }}</a></td>
                            </tr>
                            @if ($registration->message)
                                <tr>
                                    <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Message</td>
                                    <td style="padding:6px 0;">{{ $registration->message }}</td>
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
                href="{{ route('admin.trainings.index') }}"
                style="display:inline-block; background-color:#a95524; color:#ffffff; text-decoration:none; font-family:Arial, sans-serif; font-size:14px; font-weight:bold; padding:14px 28px; border-radius:999px;"
            >
                Voir dans l'espace salon
            </a>
        </td>
    </tr>
@endsection
