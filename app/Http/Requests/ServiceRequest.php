<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'motor_id' => 'required|exists:motor,id',
            'service_date' => 'required',
            'service_type' => 'required',
            'cost' => 'required|numeric',
            'description' => 'required|string|max:65535',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'motor_id' => __('label.motor'),
            'service_date' => __('label.service_date'),
            'service_type' => __('label.service_type'),
            'cost' => __('label.cost'),
            'description' => __('label.description'),
        ];
    }
}
