<?php

namespace Kernel\Application\DataBase\Model;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class Collection implements Countable, IteratorAggregate, ArrayAccess
{
    protected array $items = [];

    protected string $model;

    public function __construct(array $items = [], string $model = '')
    {
        $this->items = $items;
        $this->model = $model;
    }

    public function add(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function get(int $index): mixed
    {
        return $this->items[$index] ?? null;
    }

    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    public function last(): mixed
    {
        return !empty($this->items) ? end($this->items) : null;
    }

    public function contains(mixed $item): bool
    {
        return in_array($item, $this->items, true);
    }

    public function each(callable $callback): void
    {
        foreach ($this->items as $item) {
            $callback($item);
        }
    }

    public function map(callable $callback): static
    {
        return new static(array_map($callback, $this->items), $this->model);
    }

    public function filter(callable $callback): static
    {
        return new static(array_values(array_filter($this->items, $callback)), $this->model);
    }

    /**
     * Extract a single field from each item in the collection.
     */
    public function pluck(string $key): array
    {
        return array_map(
            fn ($item) => is_object($item) ? $item->$key : ($item[$key] ?? null),
            $this->items
        );
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    // IteratorAggregate — enables foreach($collection as $item)
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    // ArrayAccess — enables $collection[0], isset($collection[0]), unset($collection[0])
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function __toString(): string
    {
        $modelName = $this->model ?: 'Unknown Model';
        $count = count($this->items);

        $output = sprintf("%s Collection (%d items):\n", $modelName, $count);

        foreach ($this->items as $index => $item) {
            $output .= sprintf("\nItem %d:\n%s\n", $index + 1, $this->formatItem($item));
        }

        return $output;
    }

    private function formatItem(mixed $item): string
    {
        if (is_object($item)) {
            $formatted = '';
            foreach ($item as $key => $value) {
                $formatted .= sprintf("    %-20s : %s\n", ucfirst($key), $this->formatValue($value));
            }

            return $formatted;
        }

        return '[Object]';
    }

    private function formatValue(mixed $value): string
    {
        if (is_array($value)) {
            return '[Array] '.print_r($value, true);
        }

        if (is_object($value)) {
            return '[Object] '.get_class($value);
        }

        return (string) $value;
    }
}
