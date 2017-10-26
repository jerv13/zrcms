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
class ModuleConfigView
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    FindViewLayoutTagsComponent::class => [
                        'class' => This\View\Api\Repository\FindViewLayoutTagsComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterViewLayoutTagsComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    FindViewLayoutTagsComponentsBy::class => [
                        'class' => This\View\Api\Repository\FindViewLayoutTagsComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterViewLayoutTagsComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    ReadViewLayoutTagsComponentRegistry::class => [
                        'factory'
                        => This\View\Api\Component\ReadViewLayoutTagsComponentRegistryBasicFactory::class,

                    ],
                    GetRegisterViewLayoutTagsComponents::class => [
                        'class' => This\View\Api\GetRegisterViewLayoutTagsComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadViewLayoutTagsComponentRegistry::class,
                            '1-' => Cache::class
                        ],
                    ],
                ],
            ],
            'zrcms-component-registry-readers' => [
                'view-layout-tags' => ReadViewLayoutTagsComponentRegistry::class,
            ],
            'zrcms-components' => [
                'view-layout-tags' => [
                    /*
                     '{view-layout-tags-name}' => '{view-layout-tags-getter-location}(directory)'
                     OR
                     '{view-layout-tags-name}' => [
                       ComponentRegistryFields::CONFIG_LOCATION => '{view-layout-tags-location}(string)',
                       ComponentRegistryFields::COMPONENT_CONFIG_READER => '{view-layout-tags-location}(service-alias)',
                      ]
                     */
                ],
            ],
        ];
    }
}
