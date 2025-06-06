<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Authorize the request.
     */
    public function authorize(): bool
    {
        // Allow the authenticated user to proceed.
        return true;
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'     => 'sometimes|required|string|max:255',
            'last_name'      => 'sometimes|required|string|max:255',
            'address'        => 'sometimes|required|string|max:255',
            'postcode'       => 'sometimes|required|string|max:20',
            'contact_phone'  => 'sometimes|required|string|max:20',
            'username'       => ['sometimes', 'required', 'string', 'max:255', Rule::unique('users')->ignore($this->route('user'))],
            'email'          => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($this->route('user'))],
            'password'       => 'nullable|string|min:6',
        ];
    }
}
