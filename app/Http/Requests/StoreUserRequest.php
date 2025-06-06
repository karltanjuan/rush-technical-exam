<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Authorize the request.
     */
    public function authorize(): bool
    {
        return true; // Allow the request to proceed
    }

    /**
     * Validation rules for storing a new user.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'postcode'       => 'required|string|max:20',
            'contact_phone'  => 'required|string|max:20',
            'username'       => 'required|string|max:255|unique:users,username',
            'email'          => 'required|email|max:255|unique:users,email',
            'password'       => 'required|string|min:6|confirmed',
        ];
    }
}
