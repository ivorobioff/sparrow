<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Api\Support\SearchableProcessor;
use ImmediateSolutions\Core\Thing\Services\ResponderService;
use ImmediateSolutions\Support\Api\Searchable\SortableTrait;
use ImmediateSolutions\Support\Core\Criteria\Constraint;
use ImmediateSolutions\Support\Core\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationsSearchableProcessor extends SearchableProcessor
{
    use SortableTrait;

    /**
     * @return array
     */
    protected function schema()
    {
        return [
            'search' => [
                'name' => Constraint::SIMILAR
            ]
        ];
    }

    /**
     * @param Sortable $sortable
     * @return bool
     */
    protected function isResolvable(Sortable $sortable)
    {
        /**
         * @var ResponderService $responder
         */
        $responder = $this->container->get(ResponderService::class);

        return $responder->canResolveLocationSortable($sortable);
    }
}