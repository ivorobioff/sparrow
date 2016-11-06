<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

use ImmediateSolutions\Support\Framework\Web;

require __DIR__.'/../vendor/autoload.php';

define('APP_PATH', __DIR__.'/..');

if (preg_match('/^\/api\/.+/', array_get($_SERVER, 'REQUEST_URI', '/'))){
    (new Web(new ImmediateSolutions\Api\Support\ContainerRegister()))->run();
} else {
    (new Web(new ImmediateSolutions\Web\Support\ContainerRegister()))->run();
}