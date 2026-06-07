<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class VerificationCodeRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Authorization is allowed for all users (including guests).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validation rules:
     * - `email`: must be present, formatted as a valid email, and exist in the `users` table.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users'],
        ];
    }
}
