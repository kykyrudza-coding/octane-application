<?php

declare(strict_types=1);

namespace App\Requests\User;

use App\DTO\User\CreateUserDto;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => Rule::required()->min(3)->max(255),
            'email' => Rule::required()->email(),
            'password' => Rule::required()->password(),
            'password_confirm' => Rule::required()->same('password'),
        ];
    }

    public function dto(): string
    {
        return CreateUserDto::class;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            //...
        ];
    }
}