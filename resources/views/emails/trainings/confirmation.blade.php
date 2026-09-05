@extends('emails.layout')

@section('subject', 'Votre inscription à une formation')
@section('footer_note', "Vous recevez cet e-mail car vous avez soumis une inscription à une formation sur notre site.")

@section('content')
    {{-- Title --}}
    <tr>
        <td style="padding:32px 32px 8px;">
            <p style="margin:0; color:#a95524; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px;">
                Inscription bien reçue
            </p>
            <h1 style="margin:6px 0 0; color:#221812; font-size:24px;">
                Merci {{ $registration->candidate_name }} !
            </h1>
            <p style="margin:12px 0 0; color:#5f2c17; font-size:14px; line-height:1.6;">
                Votre inscription a bien été enregistrée. Le salon vous contactera prochainement par téléphone
                ou e-mail pour confirmer votre session de formation.
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
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Statut</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ \App\Models\TrainingRegistration::statusLabels()[$registration->status] ?? $registration->status }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding:8px 32px 32px; text-align:center;">
            <a
                href="{{ route('trainings.index') }}"
                style="display:inline-block; background-color:#a95524; color:#ffffff; text-decoration:none; font-family:Arial, sans-serif; font-size:14px; font-weight:bold; padding:14px 28px; border-radius:999px;"
            >
                Voir nos formations
            </a>
        </td>
    </tr>
@endsection
