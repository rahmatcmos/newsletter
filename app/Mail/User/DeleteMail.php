<?php

namespace App\Mail\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User data.
     *
     * @var object
     */
    public $user;

    /**
     * Level status.
     *
     * @var string
     */
    public $level = 'error';

    /**
     * Greeting text.
     *
     * @var string
     */
    public $greeting;

    /**
     * Intro lines.
     *
     * @var array
     */
    public $introLines = [];

    /**
     * Outro lines.
     *
     * @var array
     */
    public $outroLines = [];

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
            'Kami mohon maaf, akun kamu dengan email '.$this->user->email.' pada '.config('app.name').' telah dihapus dari sistem.',
            'Saat ini, kamus sudah tidak dapat masuk ke sistem dengan akun tersebut.',
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
            ->subject('Your Account has been Deleted');
    }
}
