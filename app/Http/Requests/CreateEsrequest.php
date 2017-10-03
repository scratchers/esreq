<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Platform;

class CreateEsrequest extends FormRequest
{
    /**
     * Authorization is handled in App\Policies\EsrequestPolicy
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
            'platform' => 'required',
            'faculty_accounts' => 'required_without_all:student_accounts',
            'date_begin' => 'nullable|date',
            'date_end'   => 'nullable|date',
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
