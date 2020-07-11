<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function questions()
    {
        return $this->belongsToMany('App\Question', 'question_votes');
    }

}
