<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterList extends Model
{
	/**
	 * Set table name
	 * 
	 * @var string
	 */
    protected $table = 'newsletter_lists';

    public function subscribers()
    {
    	return $this->hasMany(Subscriber::class, 'newsletter_list_id');
    }
}
