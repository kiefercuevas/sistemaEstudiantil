<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historical_activities extends Model
{
    protected $table = 'historical_activities';

    public function user(){
    	return $this->hasOne('App\User');
    }
}
