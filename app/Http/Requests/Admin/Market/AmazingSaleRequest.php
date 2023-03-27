<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class AmazingSaleRequest extends FormRequest
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
            'percentage' => 'required|numeric',
            'start_date' => 'required|numeric',
            'end_date' => 'required|numeric',
            'product_id' => 'required|min:1|regex:/^[0-9]+$/u|exists:products,id',
        ];
        
    }
}
