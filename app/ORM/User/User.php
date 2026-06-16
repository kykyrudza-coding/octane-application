<?php

declare(strict_types=1);

namespace App\ORM\User;

use App\ORM\User\Scopes\SoftDeleteScope;

#[Table('users')]
class User extends Model
{
    use HasTimestamps;
    use HasSoftDeletes;

    public int $id;
    public string $name;
    public string $email;
    public string $password;

    #[Column('created_at')]
    public CarbonTimestamp $createdAt;

    #[Column('updated_at')]
    public CarbonTimestamp $updatedAt;

    #[Column('deleted_at')]
    public ?CarbonTimestamp $deletedAt = null;

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
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    protected static function casts(): array
    {
        return [
            'password' => HashPasswordCast::class,
        ];
    }

    protected function posts(): HasMany
    {
        return Relation::hasMany(
            related: Post::class,
            foreignKey: 'user_id',
            localKey: 'id',
        );
    }

    protected static function observers(): array
    {
        return [
            UserObserver::class,
        ];
    }

    protected static function scopes(): array
    {
        return [
            SoftDeleteScope::class,
        ];
    }
}