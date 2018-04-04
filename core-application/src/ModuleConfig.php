<?php

namespace Zrcms\CoreApplication;

use Reliv\CacheRat\Service\Cache;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoriesToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\ComponentsToArray;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Api\Component\SearchComponentConfigs;
use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Api\Content\ContentVersionsToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Api\GetModuleDirectoryFilePath;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Api\PropertiesToArray;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\CoreApplication\Api\CmsResource\CmsResourcesToArrayBasicFactory;
use Zrcms\CoreApplication\Api\CmsResource\CmsResourceToArrayBasicFactory;
use Zrcms\CoreApplication\Api\CmsResourceHistory\CmsResourceHistoriesToArrayBasicFactory;
use Zrcms\CoreApplication\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasicFactory;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByType;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByTypeStrategyFactory;
use Zrcms\CoreApplication\Api\Component\ComponentsToArrayBasicFactory;
use Zrcms\CoreApplication\Api\Component\ComponentToArrayBasicFactory;
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
use Zrcms\CoreApplication\Api\Content\ContentToArrayBasicFactory;
use Zrcms\CoreApplication\Api\Content\ContentVersionsToArrayBasic;
use Zrcms\CoreApplication\Api\Content\ContentVersionsToArrayBasicFactory;
use Zrcms\CoreApplication\Api\Content\ContentVersionToArrayBasic;
use Zrcms\CoreApplication\Api\Content\ContentVersionToArrayBasicFactory;
use Zrcms\CoreApplication\Api\GetComponentCssBasic;
use Zrcms\CoreApplication\Api\GetComponentJsBasic;
use Zrcms\CoreApplication\Api\GetModuleDirectoryFilePathBasicFactory;
use Zrcms\CoreApplication\Api\GetTypeValueBasicFactory;
use Zrcms\CoreApplication\Api\PropertiesToArrayBasicFactory;
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
                    CmsResourcesToArray::class => [
                        'factory' => CmsResourcesToArrayBasicFactory::class,
                    ],
                    CmsResourceToArray::class => [
                        'factory' => CmsResourceToArrayBasicFactory::class,
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    CmsResourceHistoriesToArray::class => [
                        'factory' => CmsResourceHistoriesToArrayBasicFactory::class,
                    ],
                    CmsResourceHistoryToArray::class => [
                        'factory' => CmsResourceHistoryToArrayBasicFactory::class,
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
                    ComponentsToArray::class => [
                        'factory' => ComponentsToArrayBasicFactory::class,
                    ],
                    ComponentToArray::class => [
                        'factory' => ComponentToArrayBasicFactory::class,
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
                            GetServiceFromAlias::class,
                            ['literal' => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER],
                            ['literal' => ReadComponentConfigJsonFile::SERVICE_ALIAS],
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
                        'factory' => ContentToArrayBasicFactory::class,
                    ],
                    ContentVersionsToArray::class => [
                        'factory' => ContentVersionsToArrayBasicFactory::class,
                    ],
                    ContentVersionToArray::class => [
                        'factory' => ContentVersionToArrayBasicFactory::class,
                    ],

                    /**
                     * General
                     */
                    GetComponentCss::class => [
                        'class' => GetComponentCssBasic::class,
                        'arguments' => [
                            Cache::class,
                            ['literal' => GetComponentCssBasic::DEFAULT_CACHE_KEY]
                        ],
                    ],
                    GetComponentJs::class => [
                        'class' => GetComponentJsBasic::class,
                        'arguments' => [
                            Cache::class,
                            ['literal' => GetComponentJsBasic::DEFAULT_CACHE_KEY]
                        ],
                    ],
                    GetModuleDirectoryFilePath::class => [
                        'factory' => GetModuleDirectoryFilePathBasicFactory::class,
                    ],
                    GetTypeValue::class => [
                        'factory' => GetTypeValueBasicFactory::class,
                    ],
                    PropertiesToArray::class => [
                        'factory' => PropertiesToArrayBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
