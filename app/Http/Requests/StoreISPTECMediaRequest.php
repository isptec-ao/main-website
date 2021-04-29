<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreISPTECMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'slug' => [
            //     'required',
            //     'alpha_dash',
            //     Rule::unique('canvas_posts')->where(function ($query) {
            //         return $query->where('slug', request('slug'))->where('user_id', request()->user('canvas')->id);
            //     })->ignore(request('id'))->whereNull('deleted_at'),
            // ],
            'title' => 'required',
            'summary' => 'nullable|string',
            'body' => 'nullable|string',
            'published_at' => 'nullable|date',
            // 'featured_image' => 'nullable|string',
            // 'featured_image_caption' => 'nullable|string',
            'meta' => 'nullable|array',
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
        // dd(request()->all());
        $this->merge([
            // 'page_id' => request()->page_id['id'] ?? null,
            'categories' => collect(request()->categories)->pluck('id')->toArray() ?? null,
        ]);
    }
}
