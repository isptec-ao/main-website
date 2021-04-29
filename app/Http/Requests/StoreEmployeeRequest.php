<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
                'full_name' => 'required|min:4',
                'email' => 'required|email|min:2|unique:website_employees,email',
                'dob' => 'required|date',
                'receive_bday_notification' => 'required',
                'gender' => 'required',
                'avatar' => 'sometimes|nullable|mimes:jpeg,png,jpg',
            ];
        } else {
            $rules = [
                'full_name' => 'required|min:2',
                'email' => 'required|email|min:2|unique:website_employees,email,' . request()->employee,
                'dob' => 'required|date',
                'receive_bday_notification' => 'required',
                'gender' => 'required',
                'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg',
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
            'full_name' => 'Nome Completo',
            'email' => 'Email',
            'dob' => 'Data de Nascimento',
            'receive_bday_notification' => 'Receber Felicitação',
            'avatar' => 'Fotografia'
        ];
    }
}
