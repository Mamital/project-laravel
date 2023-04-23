<?php

namespace App\Http\Requests\Customer\SalesProccess;

use Illuminate\Foundation\Http\FormRequest;

class ChooseAddressAndDelivery extends FormRequest
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
            'delivery_id' => 'required|exists:delivery,id',
            'address_id' => 'required|exists:addresses,id',
        ];
    }

    public function attributes()
    {
        return [
            'address_id' => 'آدرس',
            'delivery_id' => 'روش ارسال'
        ];
    }
}
