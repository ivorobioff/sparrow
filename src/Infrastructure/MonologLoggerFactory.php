<?php
namespace ImmediateSolutions\Infrastructure;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MonologLoggerFactory
{
    /**
     * @return Logger
     */
    public function __invoke()
    {
        $logger = new Logger('default');
        $logger->pushHandler(new StreamHandler(APP_PATH.'/.sparrow/logs/app.log'));

        return $logger;
    }
}