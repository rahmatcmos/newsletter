<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Lists of supported drivers by Laravel.
     *
     * @return array
     */
    public static function getDrivers()
    {
        return [
            'mail'      => 'Mail',
            'smtp'      => 'SMTP (Simple Mail Transfer Protocol)',
            'sendmail'  => 'Sendmail',
            'mailgun'   => 'Mailgun',
            'mandrill'  => 'Mandrill',
            'ses'       => 'Amazon SES',
            'sparkpost' => 'Sparkpost',
            'log'       => 'Log',
        ];
    }
}
