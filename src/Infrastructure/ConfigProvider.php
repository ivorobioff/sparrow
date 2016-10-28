<?php
namespace ImmediateSolutions\Infrastructure;
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
         require __DIR__.'/../../config/config.php';
    }
}