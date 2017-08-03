<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponent;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponentsBy;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetRegisterBlockComponents;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetRegisterBlockComponentsBcFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\PrepareBlockConfig;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigBc;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigBcFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\GetRegisterThemeComponents;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\GetRegisterThemeComponentsBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadThemeComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadThemeComponentConfigBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadThemeComponentConfigJsonFile;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadLayoutComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadLayoutComponentConfigBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\GetRegisterViewRenderDataGetterComponents;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\GetRegisterViewRenderDataGetterComponentsBasicFactory;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\ReadViewRenderDataGetterComponentConfig;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\ReadViewRenderDataGetterComponentConfigApplicationConfig;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\ReadViewRenderDataGetterComponentConfigApplicationConfigFactory;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\ReadViewRenderDataGetterComponentConfigBasicFactory;
use Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\ReadViewRenderDataGetterComponentConfigJsonFile;
use Zrcms\ContentCoreConfigDataSource as This;
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
                    GetBlockConfigFields::class => [
                        'class' => GetBlockConfigFields::class,
                    ],
                    GetBlockConfigFieldsBcSubstitution::class => [
                        'class' => GetBlockConfigFieldsBcSubstitution::class,
                    ],
                    GetRegisterBlockComponents::class => [
                        'factory' => GetRegisterBlockComponentsBcFactory::class,
                    ],
                    PrepareBlockConfig::class => [
                        'class' => PrepareBlockConfig::class,
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    ReadBlockComponentConfig::class => [
                        'factory' => ReadBlockComponentConfigBasicFactory::class,
                    ],
                    ReadBlockComponentConfigBc::class => [
                        'factory' => ReadBlockComponentConfigBcFactory::class
                    ],
                    ReadBlockComponentConfigJsonFile::class => [
                        'class' => ReadBlockComponentConfigJsonFile::class,
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
                    ReadLayoutComponentConfig::class => [
                        'factory' => ReadLayoutComponentConfigBasicFactory::class,
                    ],
                    ReadLayoutComponentConfigJsonFile::class => [
                        'class' => ReadLayoutComponentConfigJsonFile::class,
                    ],

                    ReadThemeComponentConfig::class => [
                        'factory' => ReadThemeComponentConfigBasicFactory::class,
                    ],
                    ReadThemeComponentConfigJsonFile::class => [
                        'class' => ReadThemeComponentConfigJsonFile::class,
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
                    ReadViewRenderDataGetterComponentConfigApplicationConfig::class => [
                        'factory' => ReadViewRenderDataGetterComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadViewRenderDataGetterComponentConfig::class => [
                        'factory' => ReadViewRenderDataGetterComponentConfigBasicFactory::class,
                    ],
                    ReadViewRenderDataGetterComponentConfigJsonFile::class => [
                        'class' => ReadViewRenderDataGetterComponentConfigJsonFile::class,
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
