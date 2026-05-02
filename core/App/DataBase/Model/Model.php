<?php

namespace Kernel\Application\DataBase\Model;

use Exception;
use Kernel\Application\DataBase\DB\DataBase;
use Kernel\Application\DataBase\DB\DataBaseConnect;
use Kernel\Application\Pagination\Paginator;

abstract class Model implements ModelInterface
{
    protected static ?DataBase $db = null;

    protected static string $table = '';

    protected static array $fillable = [];

    private array $attributes = [];

    /**
     * @throws Exception
     */
    private static function initialize(): void
    {
        if (is_null(static::$db)) {
            $pdo = (new DataBaseConnect(app()->get('config')))->connect();
            static::$db = new DataBase($pdo, static::$table);
        }
    }

    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        if (in_array($name, static::$fillable)) {
            $this->attributes[$name] = $value;
        }
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * @throws Exception
     */
    public static function create(array $data): static
    {
        static::initialize();
        $filteredData = array_intersect_key($data, array_flip(static::$fillable));
        $id = static::$db->create($filteredData);
        $item = static::$db->find($id);

        return new static($item);
    }

    /**
     * @throws Exception
     */
    public static function update(int $id, array $data): static
    {
        static::initialize();
        $filteredData = array_intersect_key($data, array_flip(static::$fillable));
        static::$db->update($id, $filteredData);
        $item = static::$db->find($id);

        return new static($item);
    }

    /**
     * @throws Exception
     */
    public static function delete(int $id): bool
    {
        static::initialize();
        static::$db->delete($id);

        return true;
    }

    /**
     * @throws Exception
     */
    public static function find(int $id): ?static
    {
        static::initialize();
        $result = static::$db->find($id);

        return $result ? new static($result) : null;
    }

    /**
     * @throws Exception
     */
    public static function all(): Collection
    {
        static::initialize();
        $results = static::$db->all();
        $objects = array_map(fn ($item) => new static($item), $results);

        return new Collection($objects, static::class);
    }

    /**
     * @throws Exception
     */
    public static function first(): ?static
    {
        static::initialize();
        $result = static::$db->first();

        return $result ? new static($result) : null;
    }

    /**
     * @throws Exception
     */
    public static function where(array $conditions): Collection
    {
        static::initialize();
        $results = static::$db->where($conditions);
        $objects = array_map(fn ($item) => new static($item), $results);

        return new Collection($objects, static::class);
    }

    /**
     * @throws Exception
     */
    public static function paginate(int $perPage = 10): array
    {
        $collection = static::all();
        $currentPage = request()->get('page', 1);
        $paginator = new Paginator($collection, $perPage, $currentPage);
        $data = $paginator->handle();

        return [
            'data' => $data,
            'current_page' => $paginator->getCurrentPage(),
            'total_pages' => $paginator->getTotalPages(),
            'total_items' => $paginator->getTotalItems(),
            'per_page' => $paginator->getPerPage(),
        ];
    }

    public function fillable(): array
    {
        return static::$fillable;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }
}
