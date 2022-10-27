<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'keyword'           =>  'required|string',
            'tag'               =>  'required|string',
            'iterations'        =>  'required|integer',
            'engine_id'         =>  'required|integer',
            'device_type'       =>  'required|string|in:desktop,mobile',
            'language_id'       =>  'required|integer',
            'country_id'        =>  'required|integer'
        ];
    }
}
