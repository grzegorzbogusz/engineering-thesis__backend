<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Exceptions\Auth\EmailNotVerifiedException;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    protected function passedValidation(): void
    {
        $email = $this->validated('email');
        $user = User::whereEmail($email)->first();

        if(! $user->hasVerifiedEmail()) {
            throw new EmailNotVerifiedException;
        };
    }
}
