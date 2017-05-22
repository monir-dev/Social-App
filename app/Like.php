<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likeable';

    public function likeable()
    {
        return $this->morpTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
