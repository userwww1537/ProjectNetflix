<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required',
            'coin' => 'required',
            'country' => 'required|string',
            'description' => 'required|string',
            'parent_id' => 'required|integer',
        ];
    }

    public function messages(): array{
        $messages = require lang_path('vn/validation.php');
        return [
            'required' => $messages['required'],
            'integer'=>  $messages['integer'],
            'string'=>  $messages['string'],
        ];
    }

    public function attributes()
    {
        $messages = require lang_path('vn/validation.php');
        return $messages['attributes'];
    }
}
