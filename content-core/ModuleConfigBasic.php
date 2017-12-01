<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfig;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfigFactory;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigByStrategy;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigJsonFile;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentRegistry;
use Zrcms\ContentCore\Basic\Api\Component\GetRegisterBasicComponents;
use Zrcms\ContentCore\Basic\Api\Component\FindBasicComponent;
use Zrcms\ContentCore\Basic\Model\ServiceAliasBasic;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigBasic
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    ReadBasicComponentConfigApplicationConfig::class => [
                        'factory' => ReadBasicComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadBasicComponentConfig::class => [
                        'class' => ReadBasicComponentConfigByStrategy::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadBasicComponentConfigJsonFile::class => [
                        'class' => ReadBasicComponentConfigJsonFile::class,
                    ],
                    ReadBasicComponentRegistry::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => ReadBasicComponentRegistry::class],
                        ],
                    ],
                    FindBasicComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBasicComponent::class],
                        ],
                    ],
                    GetRegisterBasicComponents::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => GetRegisterBasicComponents::class],
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.basic.component.config-reader'
                ServiceAliasBasic::NAMESPACE_COMPONENT_CONFIG_READER => [
                    ReadBasicComponentConfigApplicationConfig::SERVICE_ALIAS
                    => ReadBasicComponentConfigApplicationConfig::class,

                    ReadBasicComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadBasicComponentConfigJsonFile::class,
                ],
            ],
        ];
    }
}
