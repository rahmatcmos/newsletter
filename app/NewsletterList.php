<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterList extends Model
{
    /**
     * Set table name.
     *
     * @var string
     */
    protected $table = 'newsletter_lists';

    /**
     * Has many subscribers.
     *
     * @return object
     */
    public function subscribers()
    {
        return $this->hasMany(\App\NewsletterSubscriber::class, 'newsletter_list_id');
    }

    /**
     * Lists belongs to Users.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /**
     * Filter newsleter list.
     *
     * @param object $query
     *
     * @return object
     */
    public function scopeFilter($query)
    {
        $query->when(request('user'), function ($query) {
            return $query->whereUserId(request('user'));
        });

        return $query;
    }
}
