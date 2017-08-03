<?php

namespace Zrcms\ServiceAlias;

use Zrcms\ServiceAlias\Api\GetService;
use Zrcms\ServiceAlias\Api\GetServiceBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceName;
use Zrcms\ServiceAlias\Api\GetServiceNameBasicFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetService::class => [
                        'factory' => GetServiceBasicFactory::class
                    ],
                    GetServiceName::class => [
                        'factory' => GetServiceNameBasicFactory::class
                    ]
                ],
            ],
            'zrcms-service-alias' => [
            ],
        ];
    }
}
