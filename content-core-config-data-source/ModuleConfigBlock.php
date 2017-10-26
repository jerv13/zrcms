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
class ModuleConfigBlock
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    FindBlockComponent::class => [
                        'class' => This\Block\Api\Repository\FindBlockComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterBlockComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => This\Block\Api\FindBlockComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterBlockComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    ReadBlockComponentRegistry::class => [
                        // @BC 'factory' => This\Block\Api\Repository\ReadBlockComponentRegistryBasicFactory::class,
                        'factory' => This\Block\Api\Component\ReadBlockComponentRegistryBcFactory::class,
                    ],
                    GetRegisterBlockComponents::class => [
                        'class' => This\Block\Api\GetRegisterBlockComponentsBasic::class,
                        'arguments' => [
                            '0-' => PrepareBlockConfigBc::class,
                            '1-' => ReadBlockComponentRegistry::class,
                            '2-' => Cache::class,
                        ],
                    ],
                ],
            ],
            'zrcms-component-registry-readers' => [
                'blocks' => ReadBlockComponentRegistry::class,
            ],
            'zrcms-components' => [
                'blocks' => [
                    /*
                    '{block-name}' => '{block-location}(directory)'
                    OR
                    '{block-name}' => [
                      ComponentRegistryFields::CONFIG_LOCATION => '{block-location}(string)',
                      ComponentRegistryFields::COMPONENT_CONFIG_READER => '{block-location}(service-alias)',
                     ]
                    */
                ],
            ],
        ];
    }
}
