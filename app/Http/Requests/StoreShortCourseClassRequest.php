<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShortCourseClassRequest extends FormRequest
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
                'course_id' => 'required|exists:website_scourses,id',
                'description' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|unique:website_scourses,name,' . request()->shortcourseclass,
                'course_id' => 'required|exists:website_scourses,id',
                'description' => 'required',
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
