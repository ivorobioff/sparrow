<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Api\Support\SearchableProcessor;
use ImmediateSolutions\Support\Core\Criteria\Constraint;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationsSearchableProcessor extends SearchableProcessor
{
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
}