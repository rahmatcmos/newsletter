<p>Halo {{ $subscriber->name }},</p>
<p>Terimakasih telah melakukan permintaan untuk berlangganan nawala. Tinggal satu langkah lagi agar pendaftaran nawala disetujui. Silakan klik tautan di bawah untuk konfirmasi pendaftaran.</p>
<p><a href="{{ url('newsletters/confirm?key=').Crypt::encrypt($subscriber->email) }}">{{ url('newsletters/confirm?key=').Crypt::encrypt($subscriber->email) }}</a></p>
<p>Abaikan email ini jika kamu merasa tidak melakukan tindakan di atas.</p>