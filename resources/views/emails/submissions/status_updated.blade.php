<x-mail::message>
# Halo {{ $submission->author_name }},

Terdapat pembaruan status pada karya Anda yang berjudul **"{{ $submission->title }}"**.

@if($submission->status === 'approved')
@if($postStatus === 'publish')
**Selamat! Kiriman Anda telah disetujui dan kini telah diterbitkan di website kami.**

Anda dapat membaca tulisan Anda secara langsung melalui tautan berikut:
<x-mail::button :url="$postLink ?? url('/artikel')">
Baca Artikel Saya
</x-mail::button>
@else
**Selamat! Kiriman karya Anda telah disetujui oleh Redaksi.**

Saat ini tulisan Anda sedang berada dalam tahap **Penyuntingan (Copy Editing)**. Kami sedang merapikannya sebelum tayang ke publik. Anda akan mendapatkan notifikasi atau pembaruan lebih lanjut begitu artikel berhasil tayang!
@endif
@else
**Mohon maaf, kiriman Anda saat ini ditolak atau belum dapat kami terbitkan.**
@endif

@if($submission->admin_notes)
**Catatan Editor / Redaksi:**
> {{ $submission->admin_notes }}
@endif

Teruslah berkarya dan menulis!<br>
Tim Redaksi {{ config('app.name') }}
</x-mail::message>
