<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Academic_period_editRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'date_first' => 'required',
			'date_last' => 'required',
			'status' => 'required',
		];
	}
}
