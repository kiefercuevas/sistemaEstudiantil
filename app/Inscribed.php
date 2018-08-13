<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscribed extends Model
{
    protected $table = 'inscribed';

    protected $fillable = [
        'sections_id','students_id',
    ];

    public function sections(){
    	return $this->hasOne('App\Sections');
    }

    public function students(){
    	return $this->hasMany('App\Students');
    }
}
