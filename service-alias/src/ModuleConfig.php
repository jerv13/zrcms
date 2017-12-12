<?php

namespace Zrcms\ServiceAlias;

use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespace;
use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespaceBasic;
use Zrcms\ServiceAlias\Api\GetServiceAliasRegistry;
use Zrcms\ServiceAlias\Api\GetServiceAliasRegistryBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\Api\GetServiceFromAliasBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceName;
use Zrcms\ServiceAlias\Api\GetServiceNameBasic;
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
                    GetServiceAliasesByNamespace::class => [
                        'class' => GetServiceAliasesByNamespaceBasic::class,
                        'arguments' => [
                            GetServiceAliasRegistry::class
                        ],
                    ],
                    GetServiceAliasRegistry::class => [
                        'factory' => GetServiceAliasRegistryBasicFactory::class
                    ],
                    GetServiceFromAlias::class => [
                        'factory' => GetServiceFromAliasBasicFactory::class
                    ],
                    GetServiceName::class => [
                        'class' => GetServiceNameBasic::class,
                        'arguments' => [
                            GetServiceAliasRegistry::class
                        ],
                    ]
                ],
            ],
            'zrcms-service-alias' => [
                ServiceAliasDefault::ZRCMS_DEFAULT => [],
            ],
        ];
    }
}
