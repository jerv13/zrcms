<?php

namespace Zrcms\Content;

use Zrcms\Content\Api\CmsResource\CmsResourceToArray;
use Zrcms\Content\Api\CmsResource\CmsResourceToArrayBasic;
use Zrcms\Content\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Content\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasic;
use Zrcms\Content\Api\Component\BuildComponentObject;
use Zrcms\Content\Api\Component\BuildComponentObjectByStrategy;
use Zrcms\Content\Api\Component\BuildComponentObjectByStrategyFactory;
use Zrcms\Content\Api\Component\ComponentToArray;
use Zrcms\Content\Api\Component\ComponentToArrayBasic;
use Zrcms\Content\Api\Component\GetRegisterComponents;
use Zrcms\Content\Api\Component\ReadComponentConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigApplicationConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigApplicationConfigFactory;
use Zrcms\Content\Api\Component\ReadComponentConfigByStrategy;
use Zrcms\Content\Api\Component\ReadComponentConfigCallable;
use Zrcms\Content\Api\Component\ReadComponentConfigCallableFactory;
use Zrcms\Content\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\Content\Api\Component\ReadComponentConfigPhpFile;
use Zrcms\Content\Api\Component\ReadComponentRegistry;
use Zrcms\Content\Api\Component\ReadComponentRegistryBasic;
use Zrcms\Content\Api\Component\ReadComponentRegistryBasicFactory;
use Zrcms\Content\Api\Component\SearchComponentListBasic;
use Zrcms\Content\Api\Content\ContentToArray;
use Zrcms\Content\Api\Content\ContentToArrayBasic;
use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Api\Content\ContentVersionToArrayBasic;
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
                    /** CmsResourceHistory */
                    CmsResourceHistoryToArray::class => [
                        'class' => CmsResourceHistoryToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class
                        ],
                    ],
                    /** CmsResource */
                    CmsResourceToArray::class => [
                        'class' => CmsResourceToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class
                        ],
                    ],
                    /** Component */
                    BuildComponentObject::class => [
                        'factory' => BuildComponentObjectByStrategyFactory::class,
                    ],

                    BuildComponentObjectByStrategy::class => [
                        'factory' => BuildComponentObjectByStrategyFactory::class,
                    ],

                    ComponentToArray::class => [
                        'class' => ComponentToArrayBasic::class,
                    ],

                    GetRegisterComponents::class => [

                    ],

                    ReadComponentRegistry::class => [
                        'class' => ReadComponentRegistryBasic::class,
                        'factory' => ReadComponentRegistryBasicFactory::class,
                    ],

                    ReadComponentConfig::class => [
                        'class' => ReadComponentConfigByStrategy::class,
                        'arguments' => [
                            GetServiceFromAlias::class
                        ],
                    ],

                    ReadComponentConfigApplicationConfig::class => [
                        'factory' => ReadComponentConfigApplicationConfigFactory::class,
                    ],

                    ReadComponentConfigByStrategy::class => [
                        'arguments' => [
                            GetServiceFromAlias::class
                        ],
                    ],

                    ReadComponentConfigCallable::class => [
                        'factory' => ReadComponentConfigCallableFactory::class,
                    ],

                    ReadComponentConfigJsonFile::class => [
                        'arguments' => [
                            ////////
                        ],
                    ],

                    ReadComponentConfigPhpFile::class => [
                        'arguments' => [
                            ////////
                        ],
                    ],

                    SearchComponentListBasic::class => [
                        'class' => SearchComponentListBasic::class,
                    ],

                    /** Content */

                    ContentToArray::class => [
                        'class' => ContentToArrayBasic::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => ContentVersionToArrayBasic::class
                    ],
                ],
            ],

            'zrcms-component-object-builder' => [
                /** {component-category} => BuildComponentObject */
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.basic.component.config-reader'
                ServiceAliasComponent::NAMESPACE_COMPONENT_CONFIG_READER => [
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
        ];
    }
}
