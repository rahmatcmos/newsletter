<?php

return [
    'title'       => 'Nawala',
    'subscribe'   => 'Berlangganan Nawala',
    'unsubscribe' => 'Berhenti Langganan',
    'reason'      => 'Kami sedih mengetahuinya. Jika kamu ada waktu, sekiranya untuk mengisi alasan berhenti berlangganan.',
    'email'       => [
        'subscribe' => [
            'subject'    => 'Konfirmasi Berlangganan Nawala',
            'greeting'   => 'Halo, :name',
            'actionText' => 'Konfirmasi',
            'intro'      => [
                'Terimakasih telah mengisi form pendaftaran untuk berlangganan Nawala.',
                'Tinggal satu langkah lagi agar kamu mendapatkan informasi terbaru melalui kotak masuk.',
            ],
            'outro'      => [
                'Dengan mengklik "Konfirmasi Berlangganan", kamu setuju dengan syarat dan ketentuan yang berlaku.',
            ],
        ],
        'confirm'   => [
            'subject'  => 'Berlangganan Telah Dikonfirmasi',
            'greeting' => 'Halo, :name',
            'intro'    => [
                'Pendaftaran kamu telah dikonfirmasi. Terimakasih telah berlangganan di nawala ' . config('app.name'),
            ],
            'outro'    => [
                'Dengan berlangganan nawala, kamu setuju dengan syarat dan ketentuan yang berlaku.',
                'Kami janji tidak ada spam atau email sampah, dan tidak lebih dari satu email setiap minggunya. Kami tidak serajin itu.',
            ],
        ],
    ],
    'form'        => [
        'name'        => 'Nama Lengkap',
        'email'       => 'Alamat Surel',
        'reasonOther' => 'Lainnya - Mohon diisi form di bawah',
    ],
    'button'      => [
        'subscribe' => 'Berlangganan Sekarang!',
        'send'      => 'Kirim',
    ],
    'message'     => [
        'subscribed'         => 'Terimakasih telah berlangganan nawala. Silakan periksa kotak masuk kamu.',
        'confirmed'          => 'Status berlangganan kamu telah dikonfirmasi.',
        'unsubscribed'       => 'Kamu telah berhenti berlangganan.',
        'noDefaultList'      => 'Default list is not defined.',
        'errorNoDefaultList' => 'Default list is not defined. Please <a href="' . route('contact') . '">contact</a> our sys admin for more information.',
        'emailNotFound'      => 'Email address not found.',
        'emailInvalid'       => 'Invalid email address.',
    ],

    // sub lang
    'subscribers' => [
        'title'       => 'Pelanggan',
        'create'      => 'Tambah Pelanggan',
        'list'        => 'Daftar Pelanggan',
        'warning'     => 'Peringatan',
        'edit'        => 'Ubah :name',
        'userDeleted' => '*Dihapus*',
        'form'        => [
            'name'     => 'Nama Lengkap',
            'email'    => 'Alamat Surel',
            'list'     => 'Daftar',
            'keyword'  => 'Katakunci',
            'user'     => 'Pengguna',
            'status'   => 'Status',
            'joinDate' => 'Tanggal',
            'action'   => 'Aksi',
            'password' => 'Katasandi',
        ],
        'button'      => [
            'create'   => 'Tambah Pelanggan',
            'save'     => 'Simpan Pelanggan',
            'truncate' => 'Hapus Semua',
            'export'   => 'Ekspor',
            'import'   => 'Impor',
            'search'   => 'Cari',
            'close'    => 'Tutup',
            'delete'   => 'Hapus',
        ],
        'message'     => [
            'created'         => 'Pelanggan baru dengan nama :name (:email) berhasil ditambahkan.',
            'noSubscriber'    => 'Data pelanggan tidak tersedia.',
            'notFound'        => 'Data pelanggan tidak ditemukan dalam bassidata.',
            'deleteWarning'   => 'Apakah kamu yakin ingin menghapus data ini? Aksi ini tidak dapat dikembalikan.',
            'passwordConfirm' => 'Masukkan katasandi untuk melanjutkan aksi ini.',
            'edited'          => 'Data pelanggan :name berhasil diperbarui.',
            'deleted'         => 'Pelanggan dengan nama :name (:email) berhasil dihapus.',
            'truncated'       => 'Semua data pelanggan telah dihapus.',
        ],
    ],

    'lists'       => [
        'title'   => 'Daftar (Grup)',
        'edit'    => 'Ubah :name',
        'yes'     => 'Ya',
        'no'      => 'Tidak',
        'create'  => 'Tambah Daftar',
        'form'    => [
            'user'        => 'Pengguna',
            'name'        => 'Nama',
            'description' => 'Deskripsi',
            'totalSubs'   => 'Total Pelanggan',
            'primary'     => 'Utama',
            'createDate'  => 'Tanggal Dibuat',
            'action'      => 'Aksi',
        ],
        'button'  => [
            'close'  => 'Tutup',
            'create' => 'Tambah Baru',
            'save'   => 'Simpan',
            'delete' => 'Hapus',
        ];
        'message' => [
            'created' => 'Daftar baru dengan nama :name berhasil dibuat.',
            'deleted' => 'Daftar berhasil dihapus.',
        ],
        'log'     => [
            'create' => 'Membuat daftar baru',
            'edit'   => 'Mengubah daftar',
            'delete' => 'Menhapus daftar',
        ],
    ],
];
