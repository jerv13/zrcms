<?php

namespace Zrcms\ServiceAlias;

use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespace;
use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespaceBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceAliasRegistry;
use Zrcms\ServiceAlias\Api\GetServiceAliasRegistryBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\Api\GetServiceFromAliasBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceName;
use Zrcms\ServiceAlias\Api\GetServiceNameBasicFactory;
use Zrcms\ServiceAlias\Api\Validator\ValidateIsZrcmsServiceAlias;
use Zrcms\ServiceAlias\Api\Validator\ValidateIsZrcmsServiceAliasFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    ValidateIsZrcmsServiceAlias::class => [
                        'factory' => ValidateIsZrcmsServiceAliasFactory::class
                    ],

                    GetServiceAliasesByNamespace::class => [
                        'factory' => GetServiceAliasesByNamespaceBasicFactory::class,
                    ],
                    GetServiceAliasRegistry::class => [
                        'factory' => GetServiceAliasRegistryBasicFactory::class
                    ],
                    GetServiceFromAlias::class => [
                        'factory' => GetServiceFromAliasBasicFactory::class
                    ],
                    GetServiceName::class => [
                        'factory' => GetServiceNameBasicFactory::class
                    ],
                ],
            ],
        ];
    }
}
