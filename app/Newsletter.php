<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
	/**
	 * Set table name
	 * 
	 * @var string
	 */
	protected $table = 'newsletters';

	/**
	 * Cast value int date object
	 * 
	 * @var array
	 */
	protected $dates = ['sent_at'];
}
