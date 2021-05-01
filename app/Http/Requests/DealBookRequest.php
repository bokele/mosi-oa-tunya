<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealBookRequest extends FormRequest
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
            'category' => 'required',
            'author' => 'required|max:100',
            'title' => 'required|min:3|max:255',
            'content' => 'required',
            'cover_image' => 'required|mimes:png,jpg,jpeg',
        ];
    }
}
