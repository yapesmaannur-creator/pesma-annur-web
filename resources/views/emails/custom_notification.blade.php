<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Sistem</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; table-layout: fixed; background-color: #f4f7f6; padding-bottom: 40px; }
        .email-content { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; }
        .email-header { background-color: #0b5ed7; padding: 25px; text-align: center; }
        .email-header img { max-height: 50px; }
        .email-body { padding: 30px; font-size: 16px; line-height: 1.6; color: #333333; }
        .email-footer { background-color: #eeeeee; padding: 20px; text-align: center; font-size: 12px; color: #777777; }
    </style>
</head>
<body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table class="email-content" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td class="email-header">
                            <img src="{{ $message->embed(public_path('assets/landing/images/logo.png')) }}" alt="Logo Website">
                        </td>
                    </tr>
                    <tr>
                        <td class="email-body">
                            {{ $content }}
                        </td>
                    </tr>
                    <tr>
                        <td class="email-footer">
                            &copy; {{ date('Y') }} Perusahaan Kami. Semua Hak Cipta Dilindungi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
