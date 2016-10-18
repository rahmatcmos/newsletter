<?php

return [
    'title'       => 'Kontak',
    'description' => 'Lebih dekat dengan kami',
    'email'       => [
        'send' => [
            'subject'  => ':subject dari :name',
            'greeting' => 'Halo, :name',
            'intro'    => [

            ],
            'outro'    => [
                'Silakan balas ini untuk menanggapi pesa tersebut',
            ],
        ],
    ],
    'form'        => [
        'name'    => 'Nama Lengkap',
        'email'   => 'Alamat Surel',
        'subject' => 'Subjek',
        'message' => 'Pesan',
    ],
    'button'      => [

    ];
    'message'     => [
        'sent'         => 'Terimakasih. Pesan berhasil dikirim.',
        'failedToSend' => 'Pesan gagal dikirim. Mohon coba lagi.',
    ],
];
