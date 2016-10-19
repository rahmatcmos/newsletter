<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Email address must be lower string
     *
     * @param string $email
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * Define user group
     *
     * @return array
     */
    public static function getGroups()
    {
        return [
            'admin' => 'Administrator',
            'user'  => 'Pengguna',
        ];
    }

    /**
     * Users has many Newsletters Lists.
     *
     * @return object
     */
    public function lists()
    {
        return $this->hasMany(\App\NewsletterList::class, 'user_id');
    }

    /**
     * Get all subscribers belongs to user via list.
     *
     * @return object
     */
    public function subscribers()
    {
        return $this->hasManyThrough(\App\NewsletterSubscriber::class, \App\NewsletterList::class);
    }
}
