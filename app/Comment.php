<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    public $timestamps = false;


    public function questions()
    {
        return $this->belongsToMany('App\Question','comment_questions');
    }

    public function answers()
    {
        return $this->belongsToMany('App\Answer','answer_comments');
    }
}
