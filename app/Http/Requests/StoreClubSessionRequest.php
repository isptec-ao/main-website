<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClubSessionRequest extends FormRequest
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
            'topic' => 'required',
            'description' => 'required',
            'date' => 'required',
            'category_id' => 'required|exists:website_cel_cats,id'
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
            'category_id' => request()->category_id['id'] ?? null,
        ]);
    }
}
