<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'nik' => 'max:16|unique:users,nik',
            'name' => 'required|max:100',
            'phone' => 'required|max:20|unique:users,phone',
            'email' => 'required|max:200|email|unique:users,email',
            'gender' => 'required',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
            'address' => 'nullable',
            'driverLicense' => 'max:20|unique:users,driverLicense'
        ];

        if ($this->method() == 'PUT') {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->user->id;
            $rules['phone'] = 'required|string|max:15|unique:users,phone,' . $this->user->id;
            $rules['password'] = 'nullable|min:8';
            $rules['password_confirm'] = 'nullable|same:password';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => __('label.name'),
            'phone' => __('label.phone_number'),
            'email' => __('label.email'),
            'address' => __('label.address'),
            'gender' => __('label.gender'),
            'password' => __('label.password'),
            'password_confirm' => __('label.confirm_password'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => str_replace('-', '', $this->phone)
        ]);
    }
}
