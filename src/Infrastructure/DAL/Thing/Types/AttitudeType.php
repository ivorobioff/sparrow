<?php
namespace ImmediateSolutions\Infrastructure\DAL\Thing\Types;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use ImmediateSolutions\Infrastructure\Doctrine\EnumType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AttitudeType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return Attitude::class;
    }
}