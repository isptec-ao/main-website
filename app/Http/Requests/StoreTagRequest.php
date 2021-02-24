<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTagRequest extends FormRequest
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
            // 'id' => 'required',
            'name' => 'required|unique:website_tags,name',
            // 'slug' => [
            //     'required',
            //     'alpha_dash',
            //     Rule::unique('website_tags')->where(function ($query) {
            //         return $query->where('slug', request('slug'))->where('user_id', request()->user('canvas')->id);
            //     })->ignore(request('id'))->whereNull('deleted_at'),
            // ],
        ];
    }
}
