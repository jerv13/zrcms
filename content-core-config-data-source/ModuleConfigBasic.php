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
                        'class' => This\Basic\Api\Repository\FindBasicComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterBasicComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    FindBasicComponentsBy::class => [
                        'class' => This\Basic\Api\Repository\FindBasicComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterBasicComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    ReadBasicComponentRegistry::class => [
                        'factory' => This\Basic\Api\Component\ReadBasicComponentRegistryBasicFactory::class,
                    ],
                    GetRegisterBasicComponents::class => [
                        'class' => This\Basic\Api\GetRegisterBasicComponentsBasic::class,
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
