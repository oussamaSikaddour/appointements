<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class SiteParamsFirstStepRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This request is typically a login step, so it's accessible publicly.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validation rules:
     * - `email`: required, must be a valid email format, and must exist in the `users` table.
     * - `password`: required, minimum 8 and maximum 255 characters.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => 'required|min:8|max:255',
        ];
    }
}
