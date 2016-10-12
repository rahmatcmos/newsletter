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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.user.create')
            ->subject('Your Email has been Registered as User at '.config('app.name'));
    }
}
