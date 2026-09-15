<x-mail::message>
# Halo Admin,

Terdapat kiriman tulisan baru yang menunggu untuk di-*review*.

**Detail Kiriman:**
- **Judul:** {{ $submission->title }}
- **Penulis:** {{ $submission->author_name }} ({{ $submission->author_email }})
- **Tanggal:** {{ $submission->created_at->format('d M Y, H:i') }}

Silakan login ke dashboard admin untuk meninjau tulisan tersebut.

<x-mail::button :url="route('admin.submissions.index')">
Review Kiriman Sekarang
</x-mail::button>

Terima kasih,<br>
Sistem {{ config('app.name') }}
</x-mail::message>
