<x-mail::message>
# Halo {{ $submission->author_name }},

Terima kasih telah mengirimkan karya Anda yang berjudul **"{{ $submission->title }}"** ke Pesantren Mahasiswa An-Nur.

Kiriman tulisan Anda telah kami terima dengan baik dan saat ini sedang berada dalam antrean *review* oleh tim redaksi kami. 
Kami akan menginformasikan kembali status tulisan Anda melalui email ini jika sudah ditinjau (apakah disetujui untuk di-*publish* atau perlu direvisi/ditolak).

<x-mail::button :url="url('/')">
Kunjungi Website
</x-mail::button>

Jazakumullah khairan katsiran,<br>
Tim Redaksi {{ config('app.name') }}
</x-mail::message>
