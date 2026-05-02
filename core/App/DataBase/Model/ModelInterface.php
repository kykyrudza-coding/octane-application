<?php

namespace Kernel\Application\DataBase\Model;

use Exception;

interface ModelInterface
{
    public static function create(array $data): static;

    public static function update(int $id, array $data): static;

    public static function delete(int $id): bool;

    public static function find(int $id): ?static;

    public static function all(): Collection;

    public static function first(): ?static;

    public static function where(array $conditions): Collection;

    /**
     * @throws Exception
     */
    public static function paginate(int $perPage = 10): array;
}
