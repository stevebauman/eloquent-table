<?php

namespace Stevebauman\EloquentTable;

use Illuminate\Pagination\Paginator;

/**
 * Class TablePaginator
 * @package Stevebauman\EloquentTable
 */
class TablePaginator extends Paginator
{
    use TableTrait;
}