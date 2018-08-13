<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;	
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'names', 'last_name', 'gender', 'office_phone', 'cellphone', 'address', 'identity_card', 'personal_phone', 'civil_status', 'email', 'password', 'status', 'rolls_id',
	];

	protected $dates = ['deleted_at'];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	/*public function setPasswordAttribute($valor){
		if(!empty($valor)){
			$this->attributes['password'] = \Hash::make($valor);
		}
	}*/
	
	public function historical_activities() {
		return $this->belongsTo('App\Historical_activities');
	}

	public function rolls() {
		return $this->hasOne('App\Rolls');
	}

	
}
