<?php

namespace Stevebauman\EloquentTable;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class TableCollection
 * @package Stevebauman\EloquentTable
 */
class TableCollection extends Collection
{
    use TableTrait;
}