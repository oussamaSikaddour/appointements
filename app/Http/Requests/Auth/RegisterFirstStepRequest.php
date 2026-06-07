<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class RegisterFirstStepRequest extends ApiFormRequest
{
    /**
     * Anyone can register, so authorization is always true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the first registration step.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }
}
