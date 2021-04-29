<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShortCourseRegistrationRequest extends FormRequest
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
                'full_name' => 'required',
                'class_id' => 'required|exists:website_scourse_class,id',
                'description' => 'required',
                'dob' => 'required',
                'id_no' => 'required',
            ];
        } else {
            $rules = [
                'full_name' => 'required',
                'class_id' => 'required|exists:website_scourse_class,id',
                'description' => 'required',
                'dob' => 'required',
                'id_no' => 'required',
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
            'class_id' => request()->class_id['id'] ?? null,
        ]);
    }
}
