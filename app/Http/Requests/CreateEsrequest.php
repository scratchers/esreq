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
            'platform' => 'required|sas_razorback',
            'faculty_accounts' => 'nullable|required_without_all:student_accounts|integer|min:1|max:32767',
            'student_accounts' => 'nullable|integer|min:1|max:32767',
            'date_begin' => 'nullable|date',
            'date_end'   => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'faculty_accounts.required_without_all' => 'You must request at least one faculty or student account.',
            'platform.sas_razorback' => 'The SAS platform is only available to University of Arkansas users.',
        ];
    }
}
