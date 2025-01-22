<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:brand,name',
            'description' => 'required|string|max:65535',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required|string|max:255|unique:brand,name,' . $this->route('brand')->id;
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => __('label.name'),
            'description' => __('label.description'),
            'logo' => __('label.logo'),
        ];
    }
}
