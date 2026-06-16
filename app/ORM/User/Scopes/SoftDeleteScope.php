<?php

declare(strict_types=1);

namespace App\ORM\User\Scopes;

final class SoftDeleteScope extends Scope
{
    public function key(): string
    {
        return SoftDeleteScope::class;
    }

    public function apply(QueryBuilder $query, ModelMetadata $metadata): void
    {
        if (! $metadata->hasColumn('deleted_at')) {
            return;
        }

        $query->whereNull('deleted_at');
    }
}
