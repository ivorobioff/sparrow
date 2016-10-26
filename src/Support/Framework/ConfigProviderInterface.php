<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ConfigProviderInterface
{
    /**
     * @return array
     */
    public function getConfig();
}