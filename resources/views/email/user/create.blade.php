<p>Halo {{ $user->name }},</p>
<p>Kamu telah didaftarkan sebagai pengguna pada {{ config('app.name') }}. Silakan klik tautan di bawah untuk menyetel ulang katasandi Anda.</p>
<p><a href="{{ url('password/reset', ['email' => $user->email]) }}">{{ url('password/reset', ['email' => $user->email]) }}</a></p>
<p>Jika kamu tidak merasa melakukan tindakan di atas, silakan abaikan email ini.</p>