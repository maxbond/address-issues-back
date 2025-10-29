<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'active' => 'required|boolean',
            'executor' => 'required|boolean',
            'admin' => 'required|boolean',
        ];
    }
}
