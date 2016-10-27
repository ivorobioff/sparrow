<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

use ImmediateSolutions\Support\Framework\Web;
use ImmediateSolutions\Support\Web\ContainerRegister;

require __DIR__.'/../vendor/autoload.php';

(new Web(new ContainerRegister()))->run();