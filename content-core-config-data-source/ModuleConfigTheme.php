<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Component\GetRegisterThemeComponents;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentRegistry;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigTheme
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    FindThemeComponent::class => [
                        'class' => This\Theme\Api\Component\FindThemeComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterThemeComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    FindThemeComponentsBy::class => [
                        'class' => This\Theme\Api\Component\FindThemeComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterThemeComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    ReadThemeComponentRegistry::class => [
                        'factory' => This\Theme\Api\Component\ReadThemeComponentRegistryBasicFactory::class,
                    ],
                    GetRegisterThemeComponents::class => [
                        'class' => This\Theme\Api\Component\GetRegisterThemeComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadThemeComponentRegistry::class,
                            '1-' => ReadLayoutComponentConfigJsonFile::class,
                            '2-' => Cache::class
                        ],
                    ],
                ],
            ],
            'zrcms-component-registry-readers' => [
                'themes' => ReadThemeComponentRegistry::class,
            ],
            'zrcms-components' => [
                'themes' => [
                    /*
                    '{theme-name}' => '{theme-location}(directory)'
                    OR
                    '{theme-name}' => [
                      ComponentRegistryFields::CONFIG_LOCATION => '{theme-location}(string)',
                      ComponentRegistryFields::COMPONENT_CONFIG_READER => '{theme-location}(service-alias)',
                     ]
                    */
                ],
            ],
        ];
    }
}
