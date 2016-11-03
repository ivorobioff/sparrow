<?php
namespace ImmediateSolutions\Api\Support;

use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Serializer
{
    /**
     * @param DateTime $datetime
     * @return string
     */
    protected function datetime(DateTime $datetime)
    {
        return $datetime->format(DateTime::ATOM);
    }
}