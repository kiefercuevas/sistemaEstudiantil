<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest {
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
			'names' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'office_phone' => 'required',
			'cellphone' => 'required',
			'gender' => 'required',
			'address' => 'required',
			'identity_card' => 'required',
			'civil_status' => 'required',
			'password' => 'required|min:8',
			'status' => 'required',
		];
	}
}
