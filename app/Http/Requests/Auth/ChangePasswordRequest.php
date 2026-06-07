<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class ChangePasswordRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * In this case, we assume the route is protected by authentication middleware,
     * so all authenticated users are authorized to use this form.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * This normalizes camelCase keys (from JSON) to snake_case,
     * ensuring consistent validation regardless of client naming conventions.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'new_password' => $this->input('newPassword', $this->input('new_password')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Rules:
     * - `password`: Required, minimum 8 characters, max 255.
     * - `new_password`: Required, minimum 8 characters, max 255,
     *                   and must be different from the current password.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'min:8', 'max:255'],
            'new_password' => ['required', 'min:8', 'max:255', 'different:password'],
        ];
    }
}
