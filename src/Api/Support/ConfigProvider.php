<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Support\Framework\ConfigProviderInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return [];
    }
}