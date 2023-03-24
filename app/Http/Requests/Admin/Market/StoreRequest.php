<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return [
                'receiver' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'sender' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'marketable_number' => 'required|regex:/^[0-9۰-۹]+$/u',
                'description' => 'required|max:500|min:5',
            ];
        } else {
            return [
                'sold_number' => 'required|regex:/^[0-9۰-۹]+$/u',
                'frozen_number' => 'required|regex:/^[0-9۰-۹]+$/u',
                'marketable_number' => 'required|regex:/^[0-9۰-۹]+$/u',
            ];
        }
    }
}
