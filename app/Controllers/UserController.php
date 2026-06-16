<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Requests\User\CreateUserRequest;
use App\Resources\User\UserResource;
use Horizon\Contracts\Http\Response\ResponseContract;

class UserController
{
    public function store(CreateUserRequest $request): ResponseContract
    {
        $dto = $request->validated()->toDto();

        $exist = QueryBuilder::for(User::class)
            ->where('email', $dto->email)
            ->exists();

        if ($exist) {
            throw new \Exception('Email already exist');
        }

        $user = QueryBuilder::for(User::class)
            ->create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => $dto->password,
            ]);

        $token = AccessToken::createFor(
            user: $user,
            name: config('app.name'),
            expires: config('app.token_expires')
        )->plainTextToken();

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => [
                'token' => $token,
                'user' => UserResource::make($user),
            ],
        ]);
    }
}