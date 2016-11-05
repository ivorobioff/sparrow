<?php
namespace ImmediateSolutions\Infrastructure;
use ImmediateSolutions\Core\Document\Interfaces\DocumentPreferenceInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentPreference implements DocumentPreferenceInterface
{
    /**
     * @return int
     */
    public function getLifeTime()
    {
        return 10; //minutes
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return 'http://igorvorobiov.com';
    }
}