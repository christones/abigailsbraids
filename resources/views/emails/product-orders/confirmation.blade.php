@extends('emails.layout')

@section('subject', 'Votre commande')
@section('footer_note', "Vous recevez cet e-mail car vous avez passé une commande sur la boutique de notre site.")

@section('content')
    <tr>
        <td style="padding:32px 32px 8px;">
            <p style="margin:0; color:#a95524; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px;">
                Commande bien reçue
            </p>
            <h1 style="margin:6px 0 0; color:#221812; font-size:24px;">
                Merci {{ $order->client_name }} !
            </h1>
            <p style="margin:12px 0 0; color:#5f2c17; font-size:14px; line-height:1.6;">
                Votre commande a bien été enregistrée. Nous la préparons et vous prévenons par e-mail dès
                qu'elle est prête à être récupérée au salon. Le paiement se fait au retrait.
            </p>
        </td>
    </tr>

    @include('emails.product-orders._details', ['order' => $order])

    <tr>
        <td style="padding:8px 32px 32px; text-align:center;">
            <a
                href="{{ route('products.index') }}"
                style="display:inline-block; background-color:#a95524; color:#ffffff; text-decoration:none; font-family:Arial, sans-serif; font-size:14px; font-weight:bold; padding:14px 28px; border-radius:999px;"
            >
                Voir la boutique
            </a>
        </td>
    </tr>
@endsection
