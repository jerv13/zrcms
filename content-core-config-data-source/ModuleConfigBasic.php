<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Basic\Api\Component\FindBasicComponent;
use Zrcms\ContentCore\Basic\Api\Component\FindBasicComponentsBy;
use Zrcms\ContentCore\Basic\Api\Component\GetRegisterBasicComponents;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentRegistry;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\Content\Api\Component\SearchComponentListBasic;

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
                    FindBasicComponent::class => [
                        'class' => This\Basic\Api\Component\FindBasicComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterBasicComponents::class,
                            '1-' => SearchComponentListBasic::class,
                        ],
                    ],
                    FindBasicComponentsBy::class => [
                        'class' => This\Basic\Api\Component\FindBasicComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterBasicComponents::class,
                            '1-' => SearchComponentListBasic::class,
                        ],
                    ],
                    ReadBasicComponentRegistry::class => [
                        'factory' => This\Basic\Api\Component\ReadBasicComponentRegistryBasicFactory::class,
                    ],
                    GetRegisterBasicComponents::class => [
                        'class' => This\Basic\Api\Component\GetRegisterBasicComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadBasicComponentRegistry::class,
                            '1-' => Cache::class,
                        ],
                    ],
                ],
            ],
            'zrcms-component-registry-readers' => [
                'basic' => ReadBasicComponentRegistry::class,
            ],
            'zrcms-components' => [
                'basic' => [
                    /*
                    '{basic-name}' => '{basic-location}(directory)'
                    OR
                    '{basic-name}' => [
                      ComponentRegistryFields::CONFIG_LOCATION => '{basic-location}(string)',
                      ComponentRegistryFields::COMPONENT_CONFIG_READER => '{basic-location}(service-alias)',
                     ]
                    */
                ],
            ],
        ];
    }
}
