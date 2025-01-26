<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
        ];

        if ($this->method() == 'PUT') {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
            $rules['phone'] = 'required|string|max:15|unique:users,phone,' . $user->id;
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => __('label.name'),
            'email' => __('label.email'),
            'phone' => __('label.phone_number'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('message.name_required'),
            'email.required' => __('message.email_required'),
            'email.email' => __('message.email_invalid'),
            'phone.required' => __('message.phone_required'),
            'phone.max' => __('message.phone_invalid'),
            'email.unique' => __('message.email_exist'),
            'phone.unique' => __('message.phone_exist'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => str_replace('-', '', $this->phone)
        ]);
    }
}
