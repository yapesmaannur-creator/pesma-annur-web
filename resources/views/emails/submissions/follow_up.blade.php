<x-mail::message>
# Halo {{ $submission->author_name }},

Terima kasih atas partisipasi Anda mengirimkan tulisan berjudul **"{{ $submission->title }}"**.

Berikut adalah pesan lanjutan dari Tim Redaksi:

> {!! nl2br(e($messageStr)) !!}

Anda dapat membalas email ini secara langsung jika ada pertanyaan lebih lanjut.

Salam hangat,<br>
Tim Redaksi {{ config('app.name') }}
</x-mail::message>
