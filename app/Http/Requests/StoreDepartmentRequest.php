<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
                'name' => 'required|unique:website_departments,name',
                'description' => 'required|unique:website_departments,description',
            ];
        } else {
            $rules = [
                'name' => 'required|unique:website_departments,name,' . request()->department,
                'description' => 'required|unique:website_departments,description,' . request()->department,
            ];
        }

        return $rules;
    }
}
