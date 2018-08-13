<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rolls extends Model
{
    protected $table = 'rolls';

    protected $fillable = [
    	'roll',
    ];

    public function User(){
    	return $this->belongTo('App\User');
    }
}
