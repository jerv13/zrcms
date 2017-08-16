<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Basic\Api\GetRegisterBasicComponents;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponentsBy;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentRegistry;
use Zrcms\ContentCore\Block\Api\GetRegisterBlockComponents;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Theme\Api\GetRegisterThemeComponents;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentRegistry;
use Zrcms\ContentCore\View\Api\GetRegisterViewLayoutTagsComponents;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponentsBy;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentRegistry;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

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
                    /**
                     * Basic Component ===========================================
                     */
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
                    /**
                     * Block Component ===========================================
                     */
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

                    /**
                     * Content (abstracts) ===========================================
                     */
                    SearchConfigList::class => [
                        'class' => SearchConfigList::class,
                    ],

                    /**
                     * Theme Component ===========================================
                     */
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

                    /**
                     * ViewLayoutTagsGetter Component ===========================================
                     */
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
                    ReadViewLayoutTagsComponentRegistry::class . '1' => [
                        'factory'
                        => This\View\Api\Component\ReadViewLayoutTagsComponentRegistryBasicFactory::class,

                    ],
                    GetRegisterViewLayoutTagsComponents::class => [
                        'class' => This\View\Api\GetRegisterViewLayoutTagsComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadViewLayoutTagsComponentRegistry::class . '1',
                            '1-' => Cache::class
                        ],
                    ],
                ],
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
