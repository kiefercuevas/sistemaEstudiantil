<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teacherSubjects extends Model
{
    protected $table = 'teachersubjects';

    protected $fillable = [
        'users_id','subjects_id',
    ];

    public function users(){
    	return $this->hasOne('App\Users');
    }

    public function subjects(){
    	return $this->hasMany('App\Subjects');
    }
}
