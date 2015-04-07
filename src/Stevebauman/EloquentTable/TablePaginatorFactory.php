<?php

namespace Stevebauman\EloquentTable;

use Illuminate\Pagination\Factory;

/**
 * Class TablePaginatorFactory
 * @package Stevebauman\EloquentTable
 */
class TablePaginatorFactory extends Factory
{
    public function make(array $items, $total, $perPage = null)
    {
        $paginatedInstance = new TablePaginator($this, $items, $total, $perPage);

        return $paginatedInstance->setupPaginationContext();
    }
}