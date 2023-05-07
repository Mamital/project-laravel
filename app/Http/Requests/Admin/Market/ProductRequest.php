<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'introduction' => 'required|max:500|min:5',
                'image' => 'required|image|mimes:png,jpg,jpeg,gif',
                'status' => 'required|numeric|in:0,1',
                'marketable' => 'required|numeric|in:0,1',
                'tags' => 'required',
                'category_id' => 'required|exists:product_categories,id',
                'brand_id' => 'required|exists:brands,id',
                'weight' => 'nullable|numeric',
                'length' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'price' => 'required|numeric',
                'published_at' => 'required|numeric',
            ];
        } else {
            return [
                'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'introduction' => 'required|max:500|min:5',
                'image' => 'image|mimes:png,jpg,jpeg,gif',
                'status' => 'required|numeric|in:0,1',
                'marketable' => 'required|numeric|in:0,1',
                'tags' => 'required',
                'category_id' => 'nullable|exists:product_categories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'weight' => 'nullable|numeric',
                'length' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'price' => 'required|numeric',
                'published_at' => 'required|numeric',
            ];
        }
    }
}
