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

    public function votes()
    {
        return $this->belongsToMany('App\Vote', 'question_votes');
    }
}