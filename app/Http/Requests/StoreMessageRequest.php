<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user('canvas')->isAdmin;
        if (auth()->guard('website')->user()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            $rules = [
                'description' => 'required|min:3|unique:website_messages,description',
                'gender' => 'required',
                'banner' => 'sometimes|nullable|mimes:jpeg,png,jpg',
            ];
        } else {
            $rules = [
                'description' => 'required|min:3|unique:website_messages,description,' . request()->message,
                'gender' => 'required',
                'banner' => 'sometimes|nullable|mimes:jpeg,png,jpg',
            ];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'description' => 'Descrição',
            'gender' => 'Gênero',
        ];
    }
}
