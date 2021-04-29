<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoursePlanRequest extends FormRequest
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
                'course_id' => 'required|exists:website_courses,id',
                'subject_id' => 'required|exists:website_subjects,id',
                'semester_id' => 'required|exists:website_semesters,id',
                'theoretical' => 'required',
                'practical' => 'required',
                'theoretical_practical' => 'required',
                'weekly_hours' => 'required',
                'semester_hours' => 'required',
            ];
        } else {
            $rules = [
                'course_id' => 'required|exists:website_courses,id',
                'subject_id' => 'required|exists:website_subjects,id',
                'semester_id' => 'required|exists:website_semesters,id',
                'theoretical' => 'required',
                'practical' => 'required',
                'theoretical_practical' => 'required',
                'weekly_hours' => 'required',
                'semester_hours' => 'required',
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
            'subject_id' => request()->subject_id['id'] ?? null,
            'semester_id' => request()->semester_id['id'] ?? null,
        ]);
    }
}
