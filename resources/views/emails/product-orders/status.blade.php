@extends('emails.layout')

@section('subject', 'Votre commande : '.$order->statusLabel())
@section('footer_note', "Vous recevez cet e-mail car le statut de votre commande sur notre boutique a changé.")

@php
    $messages = [
        \App\Models\ProductOrder::STATUS_PENDING => ['Commande en attente', 'Votre commande est de nouveau en attente de traitement. Nous revenons vers vous très vite.'],
        \App\Models\ProductOrder::STATUS_CONFIRMED => ['Commande confirmée', 'Bonne nouvelle : votre commande est confirmée et prête à être récupérée au salon. Le paiement se fait au retrait.'],
        \App\Models\ProductOrder::STATUS_SERVED => ['Commande servie', 'Votre commande vous a été remise. Merci pour votre confiance, nous espérons que vos produits vous plairont !'],
        \App\Models\ProductOrder::STATUS_CANCELLED => ['Commande annulée', 'Votre commande a été annulée. Pour toute question, ou pour passer une nouvelle commande, n\'hésitez pas à nous contacter.'],
    ];
    [$title, $text] = $messages[$order->status] ?? ['Commande mise à jour', 'Le statut de votre commande a été mis à jour.'];
@endphp

@section('content')
    <tr>
        <td style="padding:32px 32px 8px;">
            <p style="margin:0; color:#a95524; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px;">
                {{ $title }}
            </p>
            <h1 style="margin:6px 0 0; color:#221812; font-size:24px;">
                Bonjour {{ $order->client_name }},
            </h1>
            <p style="margin:12px 0 0; color:#5f2c17; font-size:14px; line-height:1.6;">
                {{ $text }}
            </p>
        </td>
    </tr>

    @include('emails.product-orders._details', ['order' => $order])

    <tr>
        <td style="padding:8px 32px 32px; text-align:center;">
            <a
                href="{{ route('contact') }}"
                style="display:inline-block; background-color:#a95524; color:#ffffff; text-decoration:none; font-family:Arial, sans-serif; font-size:14px; font-weight:bold; padding:14px 28px; border-radius:999px;"
            >
                Nous contacter
            </a>
        </td>
    </tr>
@endsection
