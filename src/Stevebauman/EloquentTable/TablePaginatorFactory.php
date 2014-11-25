<?php

namespace Stevebauman\EloquentTable;

use Stevebauman\EloquentTable\TablePaginator;
use Illuminate\Pagination\Factory;

class TablePaginatorFactory extends Factory {
    
    public function make(array $items, $total, $perPage = null)
    {
            $paginator = new TablePaginator($this, $items, $total, $perPage);
            return $paginator->setupPaginationContext();
    }
    
}