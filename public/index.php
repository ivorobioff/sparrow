<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

use ImmediateSolutions\Support\Framework\Application;
use ImmediateSolutions\Support\Application\ContainerRegister;

(new Application(new ContainerRegister()))->run();