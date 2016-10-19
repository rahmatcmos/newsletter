<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NewsletterSubscriber extends Model
{
    use Searchable;

    /**
     * Set table name.
     *
     * @var string
     */
    protected $table = 'newsletter_subscribers';

    /**
     * Set field names.
     *
     * @var array
     */
    protected $fillable = [
        'newsletter_list_id',
        'name',
        'email',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * @param $value
     * @return mixed
     */
    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = strtolower($value);
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'newsletter_subscriber_index';
    }

    /**
     * @param $value
     * @return mixed
     */
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

    /**
     * Belongs to one list
     *
     * @return object
     */
    function list() {
        return $this->belongsTo(NewsletterList::class, 'newsletter_list_id');
    }

    /**
     * Sorting options.
     *
     * @param object $query
     *
     * @return object
     */
    public function scopeSort($query)
    {
        if (!empty('by')) {
            $by = in_array(request('by'), ['ASC', 'DESC']) ? request('by') : 'ASC';
            $column = in_array(request('column'), ['name', 'status', 'email']) ? request('column') : 'name';

            return $query->orderBy($column, $by);
        }
    }
}
