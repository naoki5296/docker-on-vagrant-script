<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'thread_title' => 'required',
            'contents' => 'required|min:10',
        ];
    }
    public function messages()
    {
        return [
            'thread_title.required'  => trans('validation.required'),
            'contents.required'  => trans('validation.required'),
            'contents.min'  => trans('validation.min')
        ];
    }
}
