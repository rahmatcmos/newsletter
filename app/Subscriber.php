<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    /**
     * Set field names
     * 
     * @var array
     */
    protected $fillable = [
    	'name',
    	'email',
    	'status',
    	'created_at',
    	'updated_at'
    ];

    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = strtolower($value);
    }

    public function getStatusAttribute($value)
    {
        return $this->attributes['status'] = ucwords($value);
    }
}
