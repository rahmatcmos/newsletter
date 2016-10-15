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
     * Users has many Newsletters Lists.
     *
     * @return object
     */
    public function lists()
    {
        return $this->hasMany(\App\NewsletterList::class, 'user_id');
    }

    /**
     * Get all subscribers belongs to user via list
     *
     * @return object
     */
    public function subscribers()
    {
        return $this->hasManyThrough(\App\NewsletterSubscriber::class, \App\NewsletterList::class);
    }
}
