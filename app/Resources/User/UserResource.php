<?php

declare(strict_types=1);

namespace App\Resources\User;

use App\ORM\User\User;

class UserResource extends ApiResource
{
    public function transform(User $user): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}