<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Subscriber extends Model
{
    use Searchable;

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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->toArray();
    }

    public function scopeFilter($query)
    {
        if (! empty(request('query'))) {
            $query->where('name', 'LIKE', '%'.request('query').'%')
                ->orWhere('email', 'LIKE', '%'.request('query').'%')
                ->orWhere('status', request('query'));
        }
    }

    /**
     * Shorting options
     * 
     * @param  object $query
     * @return object    
     */
    public function scopeSort($query)
    {
        if (! empty('by')) {
            $by = in_array(request('by'), ['ASC', 'DESC']) ? request('by') : 'ASC';
            $column = in_array(request('column'), ['name', 'status', 'email']) ? request('column') : 'name';
            return $query->orderBy($column, $by);
        }
    }
}
