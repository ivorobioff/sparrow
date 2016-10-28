<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

return [
    'packages' => [
        'Thing'
    ],

    'doctrine' => [
        'db' => 'default',

        'connections' => [
            'default' => [
                'driver' => 'pdo_mysql',
                'user' => 'homestead',
                'password' => 'secret',
                'dbname' => 'slim',
                'charset' => 'utf8',
                'host' => '192.168.10.10'
            ]
        ],

        'cache' => Doctrine\Common\Cache\ArrayCache::class,
        'proxy' => [
            'auto' => Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_ALWAYS,
            'dir' => __DIR__.'/../.sparrow/proxies',
            'namespace' => 'ImmediateSolutions\Temp\Proxies'
        ],
        'migrations' => [
            'dir' => __DIR__.'/../migrations',
            'namespace' => 'ImmediateSolutions\Migrations',
            'table' => 'migrations'
        ],
        'entities' => [
           //
        ],

        'types' => [
            //
        ]
    ]
];