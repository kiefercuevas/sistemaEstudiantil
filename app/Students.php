<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'names','last_name','career','birthday', 'identity_card','civil_status','email','shift','inscribed_opportunity','opportunity_comment','debt','condition','Period','spanish','math','created_at', 'updated_at'
    ];

    public function sections(){
    	return $this->belongsTo('App\Inscribed');
    }
}
