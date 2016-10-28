<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

use ImmediateSolutions\Support\Framework\Web;
use ImmediateSolutions\Api\Support\ContainerRegister;

require __DIR__.'/../vendor/autoload.php';

define('APP_PATH', __DIR__.'/..');

(new Web(new ContainerRegister()))->run();