<?php

namespace Zrcms\Content;

use Zrcms\Cache\Service\CacheArray;
use Zrcms\Content\Api\CmsResource\CmsResourceToArray;
use Zrcms\Content\Api\CmsResource\CmsResourceToArrayBasic;
use Zrcms\Content\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Content\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasic;
use Zrcms\Content\Api\Component\BuildComponentObject;
use Zrcms\Content\Api\Component\BuildComponentObjectByStrategyFactory;
use Zrcms\Content\Api\Component\BuildComponentObjectDefault;
use Zrcms\Content\Api\Component\ComponentToArray;
use Zrcms\Content\Api\Component\ComponentToArrayBasic;
use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\Content\Api\Component\FindComponentBasic;
use Zrcms\Content\Api\Component\FindComponentsBy;
use Zrcms\Content\Api\Component\FindComponentsByBasic;
use Zrcms\Content\Api\Component\GetRegisterComponents;
use Zrcms\Content\Api\Component\GetRegisterComponentsBasic;
use Zrcms\Content\Api\Component\PrepareComponentConfig;
use Zrcms\Content\Api\Component\PrepareComponentConfigNoop;
use Zrcms\Content\Api\Component\ReadComponentConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigApplicationConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigApplicationConfigFactory;
use Zrcms\Content\Api\Component\ReadComponentConfigByStrategy;
use Zrcms\Content\Api\Component\ReadComponentConfigCallable;
use Zrcms\Content\Api\Component\ReadComponentConfigCallableFactory;
use Zrcms\Content\Api\Component\ReadComponentConfigComponentRegistryConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigComponentRegistryConfigFactory;
use Zrcms\Content\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\Content\Api\Component\ReadComponentConfigPhpFile;
use Zrcms\Content\Api\Component\ReadComponentRegistry;
use Zrcms\Content\Api\Component\ReadComponentRegistryBasicFactory;
use Zrcms\Content\Api\Component\SearchComponentList;
use Zrcms\Content\Api\Component\SearchComponentListBasic;
use Zrcms\Content\Api\Content\ContentToArray;
use Zrcms\Content\Api\Content\ContentToArrayBasic;
use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Api\Content\ContentVersionToArrayBasic;
use Zrcms\Content\Api\GetTypeValue;
use Zrcms\Content\Api\GetTypeValueBasicFactory;
use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\ComponentBasic;
use Zrcms\Content\Model\ServiceAliasComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

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
                    /**
                     * CmsResourceHistory
                     */
                    CmsResourceHistoryToArray::class => [
                        'class' => CmsResourceHistoryToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class
                        ],
                    ],

                    /**
                     * CmsResource
                     */
                    CmsResourceToArray::class => [
                        'class' => CmsResourceToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class
                        ],
                    ],

                    /**
                     * Component
                     */
                    BuildComponentObject::class => [
                        'factory' => BuildComponentObjectByStrategyFactory::class,
                    ],
                    BuildComponentObjectDefault::class => [
                        'arguments' => [
                            GetTypeValue::class,
                            ['literal' => ComponentBasic::class]
                        ],
                    ],
                    ComponentToArray::class => [
                        'class' => ComponentToArrayBasic::class,
                    ],
                    FindComponent::class => [
                        'class' => FindComponentBasic::class,
                        'arguments' => [
                            GetRegisterComponents::class,
                            SearchComponentList::class
                        ],
                    ],
                    FindComponentsBy::class => [
                        'class' => FindComponentsByBasic::class,
                        'arguments' => [
                            GetRegisterComponents::class,
                            SearchComponentList::class
                        ],
                    ],
                    GetRegisterComponents::class => [
                        'class' => GetRegisterComponentsBasic::class,
                        'arguments' => [
                            ReadComponentRegistry::class,
                            BuildComponentObject::class,
                            CacheArray::class,
                            ['literal' => GetRegisterComponentsBasic::CACHE_KEY]
                        ],
                    ],
                    PrepareComponentConfig::class => [
                        'class' => PrepareComponentConfigNoop::class
                    ],
                    PrepareComponentConfigNoop::class => [
                        'class' => PrepareComponentConfigNoop::class
                    ],

                    /** DEFAULT */
                    ReadComponentConfig::class => [
                        'class' => ReadComponentConfigByStrategy::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                            ['literal' => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER],
                            ['literal' => ReadComponentConfigJsonFile::class],
                        ],
                    ],
                    ReadComponentConfigApplicationConfig::class => [
                        'factory' => ReadComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadComponentConfigByStrategy::class => [
                        'arguments' => [
                            GetServiceFromAlias::class,
                            ['literal' => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER],
                            ['literal' => ReadComponentConfigJsonFile::class],
                        ],
                    ],
                    ReadComponentConfigCallable::class => [
                        'factory' => ReadComponentConfigCallableFactory::class,
                    ],
                    ReadComponentConfigComponentRegistryConfig::class => [
                        'factory' => ReadComponentConfigComponentRegistryConfigFactory::class,
                    ],
                    ReadComponentConfigJsonFile::class => [],
                    ReadComponentConfigPhpFile::class => [],
                    ReadComponentRegistry::class => [
                        'factory' => ReadComponentRegistryBasicFactory::class,
                    ],
                    SearchComponentList::class => [
                        'class' => SearchComponentListBasic::class,
                    ],

                    /**
                     * Content
                     */
                    ContentToArray::class => [
                        'class' => ContentToArrayBasic::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => ContentVersionToArrayBasic::class
                    ],

                    /**
                     * General
                     */
                    GetTypeValue::class => [
                        'factory' => GetTypeValueBasicFactory::class,
                    ]
                ],
            ],

            /**
             * ===== ZRCMS Components =====
             */
            'zrcms-components' => [],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.basic.component.config-reader'
                ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER => [
                    ReadComponentConfigApplicationConfig::SERVICE_ALIAS
                    => ReadComponentConfigApplicationConfig::class,

                    ReadComponentConfigCallable::SERVICE_ALIAS
                    => ReadComponentConfigCallable::class,

                    ReadComponentConfigComponentRegistryConfig::SERVICE_ALIAS
                    => ReadComponentConfigComponentRegistryConfig::class,

                    ReadComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadComponentConfigJsonFile::class,

                    ReadComponentConfigPhpFile::SERVICE_ALIAS
                    => ReadComponentConfigPhpFile::class,
                ],
            ],

            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                /* Default services and classes are defined here */
                'basic' => [
                    BuildComponentObject::class => BuildComponentObjectDefault::class,
                    PrepareComponentConfig::class => PrepareComponentConfigNoop::class,
                    ReadComponentConfig::class => ReadComponentConfigJsonFile::class,
                    'component-model-interface' => Component::class,
                    'component-model-class' => ComponentBasic::class,
                ],
            ],
        ];
    }
}
