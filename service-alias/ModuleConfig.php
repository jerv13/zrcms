<?php

namespace Zrcms\ServiceAlias;

use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\Api\GetServiceFromAliasBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceName;
use Zrcms\ServiceAlias\Api\GetServiceNameBasicFactory;
use Zrcms\ServiceAlias\Model\ServiceAliasDefault;

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
                    GetServiceFromAlias::class => [
                        'factory' => GetServiceFromAliasBasicFactory::class
                    ],
                    GetServiceName::class => [
                        'factory' => GetServiceNameBasicFactory::class
                    ]
                ],
            ],
            'zrcms-service-alias' => [
                ServiceAliasDefault::ZRCMS_DEFAULT => [],
            ],
        ];
    }
}
