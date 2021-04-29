<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShortCourseRequest extends FormRequest
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
                'name' => 'required|unique:website_scourses,name',
                'department_id' => 'required|exists:website_departments,id',
                'employee_id' => 'required|exists:website_employees,id',
                'description' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|unique:website_scourses,name,' . request()->shortcourses,
                'department_id' => 'required|exists:website_departments,id',
                'employee_id' => 'required|exists:website_employees,id',
                'description' => 'required,' . request()->shortcourses,
            ];
        }

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'department_id' => request()->department_id['id'] ?? null,
            'employee_id' => request()->employee_id['id'] ?? null,
        ]);
    }
}
