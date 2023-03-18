<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class RoleRequest extends FormRequest
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
        $route = Route::current();
        if ($route->getName() === 'admin.user.role.store') {
            return [
                'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'description' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'permission.*' => 'exists:permissions,id',
            ];
        } elseif ($route->getName() === 'admin.user.role.update') {
            return [
                'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'description' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
            ];
        }elseif ($route->getName() === 'admin.user.role.permission-update') {
            return [
                'permission.*' => 'exists:permissions,id',
            ];
        }
    }
}