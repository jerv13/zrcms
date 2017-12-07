<?php

namespace Zrcms\CoreApplication;

use Zrcms\Cache\Service\CacheArray;
use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\GetRegisterComponents;
use Zrcms\Core\Api\Component\PrepareComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Api\Component\SearchComponentList;
use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\CoreApplication\Api\ChangeLog\ChangeLogEventToString;
use Zrcms\CoreApplication\Api\ChangeLog\GetContentChangeLogComposite;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;
use Zrcms\CoreApplication\Api\CmsResource\CmsResourceToArrayBasic;
use Zrcms\CoreApplication\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasic;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByTypeFactory;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectDefault;
use Zrcms\CoreApplication\Api\Component\ComponentToArrayBasic;
use Zrcms\CoreApplication\Api\Component\FindComponentBasic;
use Zrcms\CoreApplication\Api\Component\FindComponentsByBasic;
use Zrcms\CoreApplication\Api\Component\GetRegisterComponentsBasic;
use Zrcms\CoreApplication\Api\Component\PrepareComponentConfigNoop;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigApplicationConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigApplicationConfigFactory;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigCallable;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigCallableFactory;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigComponentRegistryConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigComponentRegistryConfigFactory;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigPhpFile;
use Zrcms\CoreApplication\Api\Component\ReadComponentRegistryByTypeFactory;
use Zrcms\CoreApplication\Api\Component\SearchComponentListBasic;
use Zrcms\CoreApplication\Api\Content\ContentToArrayBasic;
use Zrcms\CoreApplication\Api\Content\ContentVersionToArrayBasic;
use Zrcms\CoreApplication\Api\GetTypeValueBasicFactory;
use Zrcms\CoreContainer\Api\ChangeLog\GetChangeLogByDateRange as ContainerGetChangeLogByDateRange;
use Zrcms\CorePage\Api\ChangeLog\GetChangeLogByDateRange as PageGetChangeLogByDateRange;
use Zrcms\CoreRedirect\Api\ChangeLog\GetChangeLogByDateRange as RedirectGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\ChangeLog\GetChangeLogByDateRange as SiteGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreTheme\Api\ChangeLog\GetChangeLogByDateRange as ThemeGetChangeLogByDateRange;

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
                     * ChangeLog
                     */
                    GetHumanReadableChangeLogByDateRange::class => [
                        'arguments' => [
                            GetChangeLogByDateRange::class,
                            ChangeLogEventToString::class
                        ]
                    ],
                    GetChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogComposite::class,
                        'calls' => [
                            ['addSubordinate', [PageGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ContainerGetChangeLogByDateRange::class]],
                            ['addSubordinate', [SiteGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ThemeGetChangeLogByDateRange::class]],
                            ['addSubordinate', [RedirectGetChangeLogByDateRange::class]],
                        ]
                    ],
                    ChangeLogEventToString::class => [
                        'class' => ChangeLogEventToString::class,
                        'arguments' => [
                            FindSiteCmsResource::class
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
                     * CmsResourceHistory
                     */
                    CmsResourceHistoryToArray::class => [
                        'class' => CmsResourceHistoryToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class,
                            CmsResourceToArray::class
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
                        'factory' => ReadComponentRegistryByTypeFactory::class,
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
