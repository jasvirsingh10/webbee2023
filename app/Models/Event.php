<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function workshops()
    {
        return $this->hasMany(Workshop::class, 'event_id', 'id');
    }
}
