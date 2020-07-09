<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function Question()
    {
        return $this->belongsTo('App\Question');
    }
}

