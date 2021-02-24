<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('website')->isAdmin;
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
            'name' => 'required|unique:website_topics,name',
            // 'slug' => [
            //     'required',
            //     'alpha_dash',
            //     Rule::unique('website_topics')->where(function ($query) {
            //         return $query->where('slug', request('slug'))->where('user_id', request()->user('website')->id);
            //     })->ignore(request('id'))->whereNull('deleted_at'),
            // ],
        ];
    }
}
