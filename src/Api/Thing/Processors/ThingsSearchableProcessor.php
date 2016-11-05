<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Api\Support\SearchableProcessor;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use ImmediateSolutions\Core\Thing\Services\ResponderService;
use ImmediateSolutions\Support\Api\Searchable\SortableTrait;
use ImmediateSolutions\Support\Core\Criteria\Constraint;
use ImmediateSolutions\Support\Core\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingsSearchableProcessor extends SearchableProcessor
{
    use SortableTrait;

    /**
     * @return array
     */
    public function schema()
    {
        return [
            'filter' => [
                'category' => Constraint::EQUAL,
                'attitude' => [
                    'constraint' => Constraint::EQUAL,
                    'type' => ['enum', Attitude::class]
                ],
                'location' => Constraint::CONTAIN
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

        return $responder->canResolveThingSortable($sortable);
    }
}