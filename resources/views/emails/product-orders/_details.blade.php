{{-- Récapitulatif d'une commande boutique (partagé par les e-mails). Variables : $order, $withClient (bool) --}}
<tr>
    <td style="padding:16px 32px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fdf6f0; border-radius:12px;">
            <tr>
                <td style="padding:20px 24px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#221812;">
                        <tr>
                            <td style="padding:6px 0; color:#5f2c17; width:140px; vertical-align:top;">Commande</td>
                            <td style="padding:6px 0; font-weight:bold;">{{ $order->reference }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Produit</td>
                            <td style="padding:6px 0; font-weight:bold;">{{ $order->product_name }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Quantité</td>
                            <td style="padding:6px 0; font-weight:bold;">{{ $order->quantity }} × {{ number_format((float) $order->unit_price, 2, ',', ' ') }} €</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Total</td>
                            <td style="padding:6px 0; font-weight:bold;">{{ number_format((float) $order->total_price, 2, ',', ' ') }} €</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Statut</td>
                            <td style="padding:6px 0; font-weight:bold;">{{ $order->statusLabel() }}</td>
                        </tr>
                        @if ($withClient ?? false)
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Cliente</td>
                                <td style="padding:6px 0; font-weight:bold;">{{ $order->client_name }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Téléphone</td>
                                <td style="padding:6px 0;"><a href="tel:{{ $order->client_phone }}" style="color:#a95524; text-decoration:none; font-weight:bold;">{{ $order->client_phone }}</a></td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">E-mail</td>
                                <td style="padding:6px 0;"><a href="mailto:{{ $order->client_email }}" style="color:#a95524; text-decoration:none; font-weight:bold;">{{ $order->client_email }}</a></td>
                            </tr>
                        @endif
                        @if ($order->notes)
                            <tr>
                                <td style="padding:6px 0; color:#5f2c17; vertical-align:top;">Message</td>
                                <td style="padding:6px 0;">{{ $order->notes }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
