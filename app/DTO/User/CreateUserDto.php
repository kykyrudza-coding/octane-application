<?php

declare(strict_types=1);

namespace App\DTO\User;

class CreateUserDto extends DataTransferObject
{
    public string $name;

    public string $email;

    public string $password;
}
