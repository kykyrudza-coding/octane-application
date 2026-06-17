<?php

declare(strict_types=1);

use Horizon\Contracts\Database\Migrations\Migratable;
use Horizon\Database\Facades\Migration;
use Horizon\Database\Migrations\Column;

return new class implements Migratable
{
    public function run(): void
    {
        Migration::create('users', [
            Column::id(),
            Column::string('name')->notNull(),
            Column::string('email')->notNull()->unique(),
            Column::string('password')->notNull(),
            Column::timestamps(),
        ]);
    }

    public function rollback(): void
    {
        Migration::dropIfExists('users');
    }
};