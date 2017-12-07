<?php

namespace Zrcms\Core;

use Zrcms\Cache\Service\CacheArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArrayBasic;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasic;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\BuildComponentObjectByTypeFactory;
use Zrcms\Core\Api\Component\BuildComponentObjectDefault;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\ComponentToArrayBasic;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentBasic;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\FindComponentsByBasic;
use Zrcms\Core\Api\Component\GetRegisterComponents;
use Zrcms\Core\Api\Component\GetRegisterComponentsBasic;
use Zrcms\Core\Api\Component\PrepareComponentConfig;
use Zrcms\Core\Api\Component\PrepareComponentConfigNoop;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigApplicationConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigApplicationConfigFactory;
use Zrcms\Core\Api\Component\ReadComponentConfigCallable;
use Zrcms\Core\Api\Component\ReadComponentConfigCallableFactory;
use Zrcms\Core\Api\Component\ReadComponentConfigComponentRegistryConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigComponentRegistryConfigFactory;
use Zrcms\Core\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\Core\Api\Component\ReadComponentConfigPhpFile;
use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Api\Component\ReadComponentRegistryTypeFactory;
use Zrcms\Core\Api\Component\SearchComponentList;
use Zrcms\Core\Api\Component\SearchComponentListBasic;
use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Api\Content\ContentToArrayBasic;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\Content\ContentVersionToArrayBasic;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Api\GetTypeValueBasicFactory;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\ServiceAliasComponent;

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
                        'factory' => BuildComponentObjectByTypeFactory::class,
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
                        'class' => ReadComponentConfigJsonFile::class,
                    ],
                    ReadComponentConfigApplicationConfig::class => [
                        'factory' => ReadComponentConfigApplicationConfigFactory::class,
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
                        'factory' => ReadComponentRegistryTypeFactory::class,
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
            'zrcms-components' => [
                /**
                 * EXAMPLE:
                 */
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
