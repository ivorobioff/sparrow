<?php
namespace ImmediateSolutions\Core\Thing\Options;
use ImmediateSolutions\Support\Core\Options\CriteriaAwareTrait;
use ImmediateSolutions\Support\Core\Options\PaginationAwareTrait;
use ImmediateSolutions\Support\Core\Options\SortablesAwareTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FetchThingsOptions
{
    use CriteriaAwareTrait;
    use SortablesAwareTrait;
    use PaginationAwareTrait;
}