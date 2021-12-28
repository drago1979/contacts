<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactPhoneRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacts.*.*' => 'sometimes|required',
            'contacts.*.*.*.description' => 'sometimes|required',
            'contacts.*.*.*.number' => 'sometimes|required',
            'new_contacts.*.*' => 'sometimes|required',
            'new_contacts.*.*.*.*' => 'sometimes|required'
        ];
    }
}
