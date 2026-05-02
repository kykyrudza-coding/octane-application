<?php

namespace Kernel\Application\Pagination;

use Kernel\Application\DataBase\Model\Collection;

/**
 * Class Paginator
 *
 * Handles the pagination logic for a given collection of items. It divides the items into pages and allows
 * navigation between pages. Provides methods to get paginated data, total pages, current page, and other
 * pagination-related information.
 */
class Paginator
{
    private array $paginatedItems = [];

    private int $currentPage;

    private int $totalItems;

    private int $totalPages;

    /**
     * Paginator constructor.
     *
     * Initializes the paginator with the given items, the number of items per page, and the current page.
     * Calculates the total number of items and pages based on the input data.
     *
     * @param  Collection  $items  The collection of items to paginate.
     * @param  int  $perPage  The number of items per page.
     * @param  int  $currentPage  The current page number. Defaults to 1.
     */
    public function __construct(
        private readonly Collection $items,
        private readonly int $perPage,
        int $currentPage = 1
    ) {
        $this->totalItems = count($this->items->toArray());
        $this->totalPages = (int) ceil($this->totalItems / $this->perPage);
        $this->currentPage = max(1, min($currentPage, $this->totalPages));
    }

    /**
     * Handles the pagination and retrieves the items for the current page.
     * This method calculates the slice of items for the current page and stores it.
     *
     * @return array The items for the current page.
     */
    public function handle(): array
    {
        $start = ($this->currentPage - 1) * $this->perPage;
        $items = $this->items->toArray();

        // Extract the items for the current page
        $this->paginatedItems = array_slice($items, $start, $this->perPage);

        return $this->paginatedItems;
    }

    /**
     * Returns the current page number.
     *
     * @return int The current page number.
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Returns the total number of pages.
     *
     * @return int The total number of pages.
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * Returns the total number of items.
     *
     * @return int The total number of items.
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * Returns the number of items per page.
     *
     * @return int The number of items per page.
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Converts the paginator data into an array for easy consumption (e.g., for API responses).
     *
     * @return array The pagination data, including current page, total pages, items per page, and paginated data.
     */
    public function toArray(): array
    {
        return [
            'current_page' => $this->getCurrentPage(),
            'per_page' => $this->getPerPage(),
            'total_items' => $this->getTotalItems(),
            'total_pages' => $this->getTotalPages(),
            'data' => $this->paginatedItems,
        ];
    }

    /**
     * Moves to the next page and returns the items for that page.
     * If the current page is the last page, it stays on the last page.
     *
     * @return array The items for the next page.
     */
    public function nextPage(): array
    {
        if ($this->currentPage < $this->totalPages) {
            $this->currentPage++;
        }

        return $this->handle();
    }

    /**
     * Moves to the previous page and returns the items for that page.
     * If the current page is the first page, it stays on the first page.
     *
     * @return array The items for the previous page.
     */
    public function previousPage(): array
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }

        return $this->handle();
    }
}
