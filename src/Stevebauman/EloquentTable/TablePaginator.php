<?php

namespace Stevebauman\EloquentTable;

use Illuminate\Pagination\Paginator;

/**
 * Class TablePaginator.
 */
class TablePaginator extends Paginator
{
    use TableTrait;
}
