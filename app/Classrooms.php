<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classrooms extends Model {
	protected $table = 'classrooms';
	protected $fillable = ['location', 'capacity'];

	public function sections() {
		return $this->belongsTo('App\Sections');
	}
}
