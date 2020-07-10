<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function Answers()
    {
        return $this->hasMany('App\Answer');
    }
    
    public function comments()
    {
        return $this->belongsToMany('App\Comment', 'comment_questions');
    }
}