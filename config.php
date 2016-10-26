<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

return [
    'container' => [
        'implementations' => [
            ImmediateSolutions\Support\Framework\RouteRegisterInterface::class =>
                ImmediateSolutions\Api\Support\RouteRegister::class
        ],
        'services' => [
            //
        ]
    ]
];