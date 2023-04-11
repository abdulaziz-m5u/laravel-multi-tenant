<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
            {    
                return [
                    'name'     => ['required'],
                    'email'    => ['required','email','unique:users'],
                    'password' => ['required'],
                    'roles.*'  => ['integer',],
                    'roles'    => ['required','array',],
                    'subdomain' => ['required', 'unique:users', 'alpha_dash'],
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'     => ['required'],
                    'email'    => ['required','unique:users,email,' . request()->route('user')->id],
                    'password' => ['required'],
                    'roles.*'  => ['integer',],
                    'roles'    => ['required','array'],
                    'subdomain' => ['required', 'alpha_dash','unique:users,subdomain,'. request()->route('user')->id],
                ];                
            }
            default: break;
        }
    }
}
