<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsletterSubscriptionRequest extends FormRequest
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
                'fullname' => 'required|unique:website_nl_subs,fullname',
                'email' => 'required|email|unique:website_nl_subs,email',
                'category_id' => 'required|exists:website_partnership_cats,id'
            ];
        } else {
            $rules = [
                'fullname' => 'required|unique:website_nl_subs,fullname,' . request()->newslettersubscription,
                'email' => 'required|unique:website_nl_subs,email,' . request()->newslettersubscription,
                'category_id' => 'required|exists:website_partnership_cats,id'
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
            'category_id' => request()->category_id['id'] ?? null,
        ]);
    }
}
