<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class CommonDiscountRequest extends FormRequest
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
            'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            // 'status' => 'required|numeric|in:0,1',
            'percentage' => 'required|numeric',
            'discount_ceiling' => 'numeric|nullable',
            'minimal_order_amount' => 'numeric',
            'start_date' => 'required|numeric',
            'end_date' => 'required|numeric',
        ];
    }
}
