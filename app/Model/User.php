<?php

namespace App\Model;

use Kernel\Application\DataBase\Model\Model;

class User extends Model
{
    protected static string $table = 'users';

    protected static array $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];
}
