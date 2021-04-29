<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecruitmentSubmissionRequest extends FormRequest
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
        return [
            'full_name' => 'required',
            'id_no' => 'required',
            'email' => 'required',
            'work_experience' => 'required',
            'tel_no' => 'required',
            'acad_id' => 'required|exists:website_acad_cats,id',
            'pub_id' => 'required|exists:website_rec_pubs,id',
        ];
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
            'acad_id' => request()->acad_id['id'] ?? null,
            'pub_id' => request()->pub_id['id'] ?? null,
        ]);
    }
}
