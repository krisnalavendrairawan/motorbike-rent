<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotorRequest extends FormRequest
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
            'name' => 'required|max:100',
            'plate' => 'required|max:20|unique:motor,plate',
            'brand_id' => 'required|exists:brand,id',
            'type' => 'required',
            'color' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|string|max:65535',
            'status' => 'nullable|string'
        ];

        if ($this->method() == 'PUT') {
            $rules['plate'] = 'required|string|max:16|unique:motor,plate,' . $this->route('bike');
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => __('label.name'),
            'plate' => __('label.plate'),
            'brand_id' => __('label.brand'),
            'type' => __('label.type'),
            'color' => __('label.color'),
            'price' => __('label.price'),
            'image' => __('label.image'),
            'description' => __('label.description'),
            'status' => __('label.status'),
        ];
    }
}
