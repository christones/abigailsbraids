<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HandlesSortOrder
{
    /**
     * The next sort_order value for a new record in the given scope, so
     * newly created items appear last by default.
     */
    protected function nextSortOrder(Builder|Relation $siblingsQuery): int
    {
        return ((int) $siblingsQuery->max('sort_order')) + 1;
    }

    /**
     * Swap two models' sort_order values, moving them past each other in
     * the display order.
     */
    protected function swapSortOrder(Model $a, Model $b): void
    {
        $orderA = $a->sort_order;
        $orderB = $b->sort_order;

        $a->update(['sort_order' => $orderB]);
        $b->update(['sort_order' => $orderA]);
    }
}
