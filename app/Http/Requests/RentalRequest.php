<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalRequest extends FormRequest
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
            'customer_id' => 'required|exists:users,id',
            'motor_id' => 'required|exists:motor,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_price' => 'required|numeric',
            'payment_type' => 'required',
            // 'status' => 'required',
            'description' => 'nullable',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'customer_id' => __('label.customer'),
            'motor_id' => __('label.motor'),
            'start_date' => __('label.start_date'),
            'end_date' => __('label.end_date'),
            'total_price' => __('label.total_price'),
            'payment_type' => __('label.payment_type'),
            // 'status' => __('label.status'),
            'description' => __('label.description'),
        ];
    }
}
