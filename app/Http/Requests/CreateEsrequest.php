<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Esrequest;

class CreateEsrequest extends FormRequest
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
            'IBM' => 'required_without_all:'.implode(',',Esrequest::$platforms),
            'faculty_accounts' => 'required_without_all:student_accounts',
            'date_begin' => 'date',
            'date_end'   => 'date',
        ];
    }

    public function messages()
    {
        return [
            'IBM.required_without_all' => 'At least one platform is required.',
            'faculty_accounts.required_without_all' =>
                'You must request at least one faculty or student account.',
        ];
    }
}
