<?php

namespace App\Http\Requests\Customer\SalesProccess;

use App\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;

class ProfileCompletionRequest extends FormRequest
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
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'email' => 'sometimes|nullable|unique:users,email|email',
            'national_code' => ["sometimes","required",'unique:users,national_code', new NationalCode()],
            'mobile' => 'sometimes|required|unique:users,mobile|min:10|max:13'
        ];
    }
}
