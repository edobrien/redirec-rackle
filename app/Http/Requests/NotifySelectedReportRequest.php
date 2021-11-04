<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotifySelectedReportRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required|string|max:50',
            'firm_name' => 'required',
            'position' => 'required',
            // 'contact_number' => 'required',
            'consent' => 'accepted',
            'selectedReport'=>'required|array|min:1'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [

            'email.required' => 'Email is required!',
            'email.email' => 'Email is not valid!',
            'name.required' => 'Name is required!',
            'position.required' => 'Position is required!',
            // 'contact_number.required' => 'Contact number is required!',
            'consent.accepted' => 'Accept Terms & Conditions!',
            'firm_name.required' => 'Firm name is required!',
            'selectedReport.required' => 'Select atleast one report!'

        ];
    }
}
