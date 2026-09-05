<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('subject', "Abigail's Braids")</title>
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

                    @yield('content')

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px; border-top:1px solid #f3d1ae; text-align:center;">
                            <p style="margin:0; color:#221812; opacity:0.5; font-size:12px; font-family:Arial, sans-serif;">
                                Abigail's Braids &middot; Strasbourg, France
                            </p>
                            <p style="margin:4px 0 0; color:#221812; opacity:0.4; font-size:11px; font-family:Arial, sans-serif;">
                                @yield('footer_note', 'Cet e-mail a été généré automatiquement.')
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
