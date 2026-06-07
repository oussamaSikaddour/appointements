<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class RegisterLastStepRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Registration finalization is public, so it's allowed by default.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validation:
     * - `email`: required, must be a valid email, and must exist in the users table.
     * - `code`: required, max length of 6 characters (OTP or verification code).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => ['required', 'digits:6'],
        ];
    }
}
