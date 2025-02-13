<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerProfileRequest extends FormRequest
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
            'nik' => 'required|string|max:16|unique:users,nik,' . $user->id,
            'name' => 'required|max:100',
            'phone' => 'required|string|max:15|unique:users,phone,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required',
            'address' => 'required',
            'driverLicense' => 'required|string|max:20|unique:users,driverLicense,' . $user->id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        // Only validate password fields if old_password is present
        if ($this->filled('old_password')) {
            $rules['old_password'] = ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail(__('string.old_password_wrong'));
                }
            }];
            $rules['new_password'] = 'required|min:8';
            $rules['new_password_confirmation'] = 'required|same:new_password';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'nik' => __('label.nik'),
            'driverLicense' => __('label.driver_license'),
            'name' => __('label.name'),
            'phone' => __('label.phone_number'),
            'email' => __('label.email'),
            'address' => __('label.address'),
            'gender' => __('label.gender'),
            'driverLicense' => __('label.driver_license'),
            'old_password' => __('label.old_password'),
            'password' => __('label.password'),
            'password_confirm' => __('label.confirm_password'),
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone' => str_replace('-', '', $this->phone),
            'customer' => $this->route('customer')  // Add this line to get the customer from route binding
        ]);
    }
}
