<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequest extends FormRequest
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
            'rental_id' => 'required|integer|exists:rental,id',
            'return_date' => 'required|date',
        ];


        return $rules;
    }

    public function attributes()
    {
        return [
            'rental_id' => __('label.rental'),
            'return_date' => __('label.retrun_date'),
        ];
    }
}
