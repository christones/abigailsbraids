@extends('emails.layout')

@section('subject', 'Nouvelle commande boutique')
@section('footer_note', "Cet e-mail a été généré automatiquement suite à une commande passée sur la boutique en ligne.")

@section('content')
    <tr>
        <td style="padding:32px 32px 8px;">
            <p style="margin:0; color:#a95524; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:1.5px;">
                Nouvelle commande
            </p>
            <h1 style="margin:6px 0 0; color:#221812; font-size:24px;">
                Commande boutique reçue
            </h1>
            <p style="margin:12px 0 0; color:#5f2c17; font-size:14px; line-height:1.6;">
                {{ $order->client_name }} vient de commander un produit. Voici le récapitulatif :
            </p>
        </td>
    </tr>

    @include('emails.product-orders._details', ['order' => $order, 'withClient' => true])

    <tr>
        <td style="padding:8px 32px 32px; text-align:center;">
            <a
                href="{{ route('admin.product-orders.index') }}"
                style="display:inline-block; background-color:#a95524; color:#ffffff; text-decoration:none; font-family:Arial, sans-serif; font-size:14px; font-weight:bold; padding:14px 28px; border-radius:999px;"
            >
                Gérer la commande
            </a>
        </td>
    </tr>
@endsection
