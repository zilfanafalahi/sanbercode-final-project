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

    public function comments()
    {
        return $this->belongsToMany('App\Comment','answer_comments');
    }
}

