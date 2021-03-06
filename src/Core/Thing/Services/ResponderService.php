<?php
namespace ImmediateSolutions\Core\Thing\Services;
use ImmediateSolutions\Core\Thing\Criteria\LocationSorterResolver;
use ImmediateSolutions\Core\Thing\Criteria\ThingSorterResolver;
use ImmediateSolutions\Support\Core\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ResponderService
{
    /**
     * @param Sortable $sortable
     * @return bool
     */
    public function canResolveThingSortable(Sortable $sortable)
    {
        return (new ThingSorterResolver())->canResolve($sortable);
    }

    /**
     * @param Sortable $sortable
     * @return bool
     */
    public function canResolveLocationSortable(Sortable $sortable)
    {
        return (new LocationSorterResolver())->canResolve($sortable);
    }
}