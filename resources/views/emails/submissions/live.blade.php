<x-mail::message>
# Halo {{ $submission->author_name }},

Kabar baik! Pihak Redaksi telah selesai menyunting dan meninjau tulisan Anda yang berjudul **"{{ $submission->title }}"**.

**Kini, tulisan Anda telah resmi diterbitkan dan ditayangkan secara publik di website kami!** Anda dapat membaca, membagikan, serta menyebarkan tulisan Anda secara langsung melalui tautan (URL) di bawah ini:

<x-mail::button :url="$postLink">
Baca Artikel Saya
</x-mail::button>

Terima kasih karena telah menjadi kontributor yang berharga dalam menyebarkan inspirasi. Kami tunggu karya-karya luar biasa Anda selanjutnya!

Salam hangat,<br>
Tim Redaksi {{ config('app.name') }}
</x-mail::message>
