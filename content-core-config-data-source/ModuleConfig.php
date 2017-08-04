<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponent;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponentsBy;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetRegisterBlockComponents;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetRegisterBlockComponentsBcFactory;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\GetRegisterThemeComponents;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\GetRegisterThemeComponentsBasicFactory;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\GetRegisterViewRenderDataGetterComponents;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\GetRegisterViewRenderDataGetterComponentsBasicFactory;

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
                    GetRegisterBlockComponents::class => [
                        'factory' => GetRegisterBlockComponentsBcFactory::class,
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
                    GetRegisterThemeComponents::class => [
                        'factory' => GetRegisterThemeComponentsBasicFactory::class,
                    ],

                    /**
                     * ViewRenderDataGetter Component ===========================================
                     */
                    FindViewRenderDataGetterComponent::class => [
                        'class' => This\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterViewRenderDataGetterComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    FindViewRenderDataGetterComponentsBy::class => [
                        'class' => This\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterViewRenderDataGetterComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    GetRegisterViewRenderDataGetterComponents::class => [
                        'factory' => GetRegisterViewRenderDataGetterComponentsBasicFactory::class,
                    ],
                ],
            ],
            'zrcms' => [
                'blocks' => [
                    /*
                    '{block-name}' => '{block-location}(directory)'
                    OR
                    '{block-name}' => [
                      ComponentConfigFields::LOCATION => '{block-location}(service-name)',
                      ComponentConfigFields::COMPONENT_CONFIG_READER => '{block-location}(service-name)',
                     ]
                    */
                ],
                'themes' => [
                    /*
                    '{theme-name}' => '{theme-location}(directory)'
                    OR
                    '{theme-name}' => [
                      ComponentConfigFields::LOCATION => '{theme-location}(service-name)',
                      ComponentConfigFields::COMPONENT_CONFIG_READER => '{theme-location}(service-name)',
                     ]
                    */
                ],
                'view-render-data-getters' => [
                    /*
                     '{view-render-data-getter-name}' => '{view-render-data-getter-location}(directory)'
                     OR
                     '{view-render-data-getter-name}' => [
                       ComponentConfigFields::LOCATION => '{view-render-data-getter-location}(service-name)',
                       ComponentConfigFields::COMPONENT_CONFIG_READER => '{view-render-data-getter-location}(service-name)',
                      ]
                     */
                ],
            ],
        ];
    }
}
