<?php

declare(strict_types=1);

namespace App\ORM\User;

use App\ORM\Post\Post;
use Horizon\Halcyon\Model\Attributes\Table;
use Horizon\Halcyon\Model\Model;
use Horizon\Halcyon\Model\Traits\HasSoftDeletes;
use Horizon\Halcyon\Model\Traits\HasTimestamps;
use Horizon\Halcyon\Relations\HasMany;
use Horizon\Halcyon\Relations\Relation;

#[Table('users')]
class User extends Model
{
    use HasTimestamps;
    use HasSoftDeletes;

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

    protected function posts(): HasMany
    {
        return Relation::hasMany(
            related: Post::class,
            foreignKey: 'user_id',
            localKey: 'id',
            name: 'posts',
        );
    }
}