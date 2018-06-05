<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['miasto', 'kraj', 'omnie', 'user_id', 'website'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
