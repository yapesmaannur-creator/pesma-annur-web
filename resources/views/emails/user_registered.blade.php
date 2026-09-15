<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informasi Akun Anda</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #ffffff;">
        <h2 style="color: #2c3e50; margin-top: 0;">Halo, {{ $user->name }}!</h2>
        <p>Akun Anda telah berhasil didaftarkan oleh Administrator. Anda sekarang memiliki hak akses ke dalam sistem kami dengan jabatan sebagai <strong>{{ $user->role_label }}</strong>.</p>
        
        <p>Gunakan kredensial berikut untuk masuk (login) ke panel kami:</p>
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0; border: 1px solid #eeeeee;">
            <p style="margin: 0 0 10px 0;"><strong>Halaman Login:</strong> <br><a href="{{ url('/admin') }}" style="color: #0d6efd;">{{ url('/admin') }}</a></p>
            <p style="margin: 0 0 5px 0;"><strong>Email:</strong> <span style="font-weight: bold; color: #111;">{{ $user->email }}</span></p>
            <p style="margin: 0;"><strong>Password:</strong> <span style="font-weight: bold; color: #111;">{{ $password }}</span></p>
        </div>

        <p><em>* Kami sangat menyarankan Anda untuk segera mengganti password bawaan ini setelah Anda berhasil masuk pertama kali, melalui menu <strong>Profil</strong> Anda di pojok kanan atas.</em></p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="margin: 0; font-size: 14px;"><strong>Salam hangat,</strong></p>
        <p style="margin: 5px 0 0 0; font-size: 14px;">Tim Administrator {{ \App\Models\Setting::getByKey('site_name') ?? 'Pesma An-Nur' }}</p>
    </div>
</body>
</html>
