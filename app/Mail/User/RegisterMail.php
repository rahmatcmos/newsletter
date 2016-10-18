<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $level = 'success';

    /**
     * [$greeting description]
     * @var string
     */
    public $greeting;

    /**
     * [$introLines description]
     * @var array
     */
    public $introLines = [];

    /**
     * [$outroLines description]
     * @var array
     */
    public $outroLines = [];

    /**
     * [$actionText description]
     * @var string
     */
    public $actionText = 'Aktifkan Keanggotaan';

    /**
     * [$actionLink description]
     * @var [type]
     */
    public $actionUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->greeting = 'Halo, ' . $user->name;

        $this->introLines = [
            'Kamu telah melakukan pendaftaran di aplikasi ' . config('app.name') . '. Tinggal satu langkah lagi agar keanggotaan kamu aktif.',
            'Klik pada tombol di bawah untuk mengaktifkan keanggotaan.',
        ];

        $this->actionUrl = url('activate', ['key' => \Crypt::encrypt($user->email)]);

        $this->outroLines = [
            'Jika kamu merasa tidak melakukan tindakan di atas, abaikan email ini.',
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.default')
            ->subject(sprintf('Registration on %s', config('app.name')));
    }
}
