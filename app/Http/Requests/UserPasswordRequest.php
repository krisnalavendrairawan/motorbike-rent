<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserPasswordRequest extends FormRequest
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
        return [
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail(_('string.old_password_wrong'));
                }
            }],

            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8'
        ];
    }

    public function attributes()
    {
        return [
            'old_password' => __('label.old_password'),
            'new_password' => __('label.new_password'),
            'new_password_confirmation' => __('label.new_password_confirmation')
        ];
    }
}
