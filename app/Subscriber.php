<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Subscriber extends Model
{
    // use Searchable;

    /**
     * Set table name
     * 
     * @var string
     */
    protected $table = 'newsletter_subscribers';

    /**
     * Set field names
     * 
     * @var array
     */
    protected $fillable = [
        'newsletter_list_id',
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

    public function list()
    {
        return $this->belongsTo(NewsletterList::class, 'newsletter_list_id');
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

    /**
     * Filter data by list and query string
     * 
     * @param  object $query
     * @param  object $list 
     * @return object      
     */
    public function scopeFilter($query, $list = null)
    {
        if (! empty($list)) {
            $query->where('newsletter_list_id', $list->id);
        }

        if (! empty(request('query'))) {
            $query->where('name', 'LIKE', '%'.request('query').'%')
                ->orWhere('email', 'LIKE', '%'.request('query').'%')
                ->orWhere('status', request('query'));
        }

        return $query;
    }

    /**
     * Sorting options
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
