<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academic_periods extends Model {
	protected $table = 'academic_periods';

	protected $fillable = ['academic_period', 'date_first', 'date_last', 'status'];

	public function sections() {
		return $this->belongsTo('App\Sections');
	}
}
