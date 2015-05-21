<?php

namespace Stevebauman\EloquentTable;

use Illuminate\Pagination\Factory;

/**
 * Class TablePaginatorFactory.
 */
class TablePaginatorFactory extends Factory
{
    /**
     * Creates and returns a new paginated instance.
     *
     * @param array $items
     * @param int   $total
     * @param null  $perPage
     *
     * @return $this
     */
    public function make(array $items, $total, $perPage = null)
    {
        $paginatedInstance = new TablePaginator($this, $items, $total, $perPage);

        return $paginatedInstance->setupPaginationContext();
    }
}
