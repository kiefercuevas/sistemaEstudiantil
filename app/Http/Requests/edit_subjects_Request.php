<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class edit_subjects_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code_subject' =>   'required',
            'subject'      =>   'required',
            'credits'      =>   'required|min:1|max:8|numeric',
        ];
    }
}
