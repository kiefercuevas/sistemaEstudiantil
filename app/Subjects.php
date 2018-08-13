<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';
    protected $fillable = ['code_subject','subject','credits'];

    public function sections(){
    	return $this->hasMany('App\Sections');
    }

    public function teachers(){
    	return $this->belongsToMany('App\Teachers', 'Subjects_Teachers', 'subjects_id', 'teachers_id');
    }
}
