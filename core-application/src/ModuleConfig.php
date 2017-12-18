<?php

namespace Zrcms\CoreApplication;

use Zrcms\Cache\Service\Cache;
use Zrcms\Cache\Service\CacheArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Api\Component\SearchComponentConfigs;
use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\CoreApplication\Api\CmsResource\CmsResourceToArrayBasic;
use Zrcms\CoreApplication\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasic;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByType;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByTypeStrategyFactory;
use Zrcms\CoreApplication\Api\Component\ComponentToArrayBasic;
use Zrcms\CoreApplication\Api\Component\FindComponentBasic;
use Zrcms\CoreApplication\Api\Component\FindComponentsByBasic;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigApplicationConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigApplicationConfigFactory;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigCallable;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigCallableFactory;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigPhpFile;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigsBasic;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigServiceAliasScheme;
use Zrcms\CoreApplication\Api\Component\ReadComponentRegistryBasic;
use Zrcms\CoreApplication\Api\Component\ReadComponentRegistryBasicFactory;
use Zrcms\CoreApplication\Api\Component\ReadComponentRegistryCompositeFactory;
use Zrcms\CoreApplication\Api\Component\SearchComponentConfigsBasic;
use Zrcms\CoreApplication\Api\Content\ContentToArrayBasic;
use Zrcms\CoreApplication\Api\Content\ContentVersionToArrayBasic;
use Zrcms\CoreApplication\Api\GetComponentCssBasic;
use Zrcms\CoreApplication\Api\GetComponentJsBasic;
use Zrcms\CoreApplication\Api\GetTypeValueBasicFactory;
use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespace;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

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
                    /**
                     * CmsResource
                     */
                    CmsResourceToArray::class => [
                        'class' => CmsResourceToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class,
                        ],
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    CmsResourceHistoryToArray::class => [
                        'class' => CmsResourceHistoryToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class,
                            CmsResourceToArray::class,
                        ],
                    ],

                    /**
                     * Component
                     */
                    BuildComponentObject::class => [
                        'factory' => BuildComponentObjectByTypeStrategyFactory::class,
                    ],
                    BuildComponentObjectByType::class => [
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
                            FindComponentsBy::class,
                        ],
                    ],
                    FindComponentsBy::class => [
                        'class' => FindComponentsByBasic::class,
                        'arguments' => [
                            SearchComponentConfigs::class,
                            ReadComponentConfigs::class,
                            BuildComponentObject::class,
                        ],
                    ],

                    /** DEFAULT */
                    ReadComponentConfig::class => [
                        'class' => ReadComponentConfigServiceAliasScheme::class,
                        'arguments' => [
                            GetServiceAliasesByNamespace::class,
                            GetServiceFromAlias::class,
                            ['literal' => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER]
                        ]
                    ],
                    ReadComponentConfigApplicationConfig::class => [
                        'factory' => ReadComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadComponentConfigCallable::class => [
                        'factory' => ReadComponentConfigCallableFactory::class,
                    ],
                    ReadComponentConfigJsonFile::class => [],
                    ReadComponentConfigPhpFile::class => [],
                    ReadComponentConfigs::class => [
                        'class' => ReadComponentConfigsBasic::class,
                        'arguments' => [
                            ReadComponentRegistry::class,
                            ReadComponentConfig::class,
                            Cache::class,
                            ['literal' => ReadComponentConfigsBasic::DEFAULT_CACHE_KEY],
                        ],
                    ],
                    ReadComponentRegistry::class => [
                        'factory' => ReadComponentRegistryCompositeFactory::class,
                    ],
                    ReadComponentRegistryBasic::class => [
                        'factory' => ReadComponentRegistryBasicFactory::class,
                    ],
                    SearchComponentConfigs::class => [
                        'class' => SearchComponentConfigsBasic::class,
                    ],

                    /**
                     * Content
                     */
                    ContentToArray::class => [
                        'class' => ContentToArrayBasic::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => ContentVersionToArrayBasic::class,
                    ],

                    /**
                     * General
                     */
                    GetTypeValue::class => [
                        'factory' => GetTypeValueBasicFactory::class,
                    ],
                    GetComponentCss::class => [
                        'class' => GetComponentCssBasic::class,
                        'arguments' => [
                            CacheArray::class,
                            ['literal' => GetComponentCssBasic::DEFAULT_CACHE_KEY]
                        ],
                    ],
                    GetComponentJs::class => [
                        'class' => GetComponentJsBasic::class,
                        'arguments' => [
                            CacheArray::class,
                            ['literal' => GetComponentJsBasic::DEFAULT_CACHE_KEY]
                        ],
                    ]
                ],
            ],

            /**
             * ===== ZRCMS Component Registry =====
             */
            'zrcms-components' => [
                /* '{type.name}' => '{config-location}' */
            ],

            /**
             * ===== ZRCMS Component Registry Readers =====
             */
            'zrcms-component-registry-readers' => [
                /* '{service-name}' => '{service-name}' */
                ReadComponentRegistryBasic::class => ReadComponentRegistryBasic::class,
            ],

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
                    BuildComponentObject::class => BuildComponentObjectByType::class,
                    'component-model-interface' => Component::class,
                    'component-model-class' => ComponentBasic::class,
                ],
            ],
        ];
    }
}
