<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reputation extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function users()
    {
        return $this->hasOne('App\User');
    }
}
