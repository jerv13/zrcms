<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\Content\Api\Component\ReadAllComponentConfigs;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentRegistry;
use Zrcms\ContentCore\Basic\Api\GetRegisterBasicComponents;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponentsBy;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Api\GetRegisterBlockComponents;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentRegistry;
use Zrcms\ContentCore\Theme\Api\GetRegisterThemeComponents;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentRegistry;
use Zrcms\ContentCore\View\Api\GetRegisterViewLayoutTagsComponents;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponentsBy;
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
                        'class' => This\Theme\Api\Repository\FindThemeComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterThemeComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    FindThemeComponentsBy::class => [
                        'class' => This\Theme\Api\Repository\FindThemeComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterThemeComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    ReadThemeComponentRegistry::class => [
                        'factory' => This\Theme\Api\Component\ReadThemeComponentRegistryBasicFactory::class,
                    ],
                    GetRegisterThemeComponents::class => [
                        'class' => This\Theme\Api\GetRegisterThemeComponentsBasic::class,
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
