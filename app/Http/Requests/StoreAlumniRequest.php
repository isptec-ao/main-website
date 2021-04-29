<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlumniRequest extends FormRequest
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
                'student_full_name' => 'required|unique:website_alumni,student_full_name',
                'summary' => 'sometimes|nullable|string|min:10',
                'course_id' => 'required|exists:website_courses,id'
            ];
        } else {
            $rules = [
                'student_full_name' => 'required|unique:website_alumni,student_full_name,' . request()->alumni,
                'summary' => 'sometimes|nullable|string|min:10',
                'course_id' => 'required|exists:website_courses,id'
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
            'course_id' => request()->course_id['id'] ?? null,
        ]);
    }
}
