<?php

namespace App\Mail\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User data.
     *
     * @var object
     */
    public $user;

    public $level = 'success';
    public $greeting;
    public $introLines;
    public $actionText;
    public $actionUrl;
    public $outroLines;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->greeting = 'Halo, '.$this->user->name;

        $this->introLines = [
            'Kamu telah didaftarkan sebagai pengguna pada '.config('app.name').'. Silakan klik tautan di bawah untuk menyetel ulang katasandi Anda.',
        ];

        $this->actionText = 'Setel Katasandi';

        $this->actionUrl = url('password/reset', ['email' => $this->user->email]);

        $this->outroLines = [
            'Jika kamu tidak merasa melakukan tindakan di atas, silakan abaikan email ini.',
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
            ->subject('Your Email has been Registered as User');
    }
}
