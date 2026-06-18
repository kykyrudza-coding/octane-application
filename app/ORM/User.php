<?php

declare(strict_types=1);

namespace App\ORM;

use Horizon\Halcyon\Model\Attributes\Table;
use Horizon\Halcyon\Model\Model;
use Horizon\Halcyon\Model\Traits\HasTimestamps;

#[Table('users')]
class User extends Model
{
    use HasTimestamps;

    public int $id;
    public string $name;
    public string $email;
    public string $password;

    protected static function hidden(): array
    {
        return [
            'password',
        ];
    }

    protected static function guarded(): array
    {
        return [
            'id',
            'password'
        ];
    }
}