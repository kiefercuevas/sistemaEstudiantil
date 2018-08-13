<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    protected $table = 'sections';

    protected $fillable = [
        'section','status','time_first','time_last','second_time_first','second_time_last', 'quota','day_one','day_two','shift','classrooms_id','subjects_id','academic_periods_id','users_id',
    ];

    public function subjects(){
        return $this->belongsTo('App\Subjects');
    }

    public function classrooms(){
    	return $this->hasOne('App\Classrooms');
    }

    public function teachers(){
    	return $this->hasOne('App\Teachers');
    }

    public function academic_periods(){
    	return $this->hasOne('App\Academic_periods');
    }

    public function inscribed(){
    	return $this->belongsTo('App\Inscribed');
    }
}
