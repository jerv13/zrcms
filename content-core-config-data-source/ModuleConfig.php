<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;
use Zrcms\ContentCore\Page\Model\PropertiesPage;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHead;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadAll;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataPage;
use Zrcms\ContentCore\View\Api\Repository\FindViewComponent;
use Zrcms\ContentCore\View\Api\Repository\FindViewComponentsBy;
use Zrcms\ContentCore\View\Model\PropertiesViewComponent;
use Zrcms\ContentCore\View\Model\ViewComponent;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetConfigBlockComponents;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetConfigBlockComponentsBcFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\PrepareBlockConfig;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigBc;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigBcFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\GetConfigThemeComponents;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\GetConfigThemeComponentsBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadThemeComponentConfig;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadThemeComponentConfigBasicFactory;
use Zrcms\ContentCoreConfigDataSource\Theme\Api\ReadThemeComponentConfigJsonFile;
use Zrcms\ContentCoreConfigDataSource\View\Api\GetConfigViewComponents;
use Zrcms\ContentCoreConfigDataSource\View\Api\GetConfigViewComponentsBasicFactory;
use Zrcms\ContentCoreConfigDataSource\View\Api\ReadViewComponentConfig;
use Zrcms\ContentCoreConfigDataSource\View\Api\ReadViewComponentConfigApplicationConfig;
use Zrcms\ContentCoreConfigDataSource\View\Api\ReadViewComponentConfigApplicationConfigFactory;
use Zrcms\ContentCoreConfigDataSource\View\Api\ReadViewComponentConfigJsonFile;

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
                    /** Block **/
                    // @override
                    FindBlockComponent::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\Block\Api\FindBlockComponent::class,
                        'arguments' => [
                            GetConfigBlockComponents::class,
                            SearchConfigList::class,
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\Block\Api\FindBlockComponentsBy::class,
                        'arguments' => [
                            GetConfigBlockComponents::class,
                            SearchConfigList::class,
                        ],
                    ],
                    GetBlockConfigFields::class => [
                        'class' => GetBlockConfigFields::class,
                        'arguments' => [
                        ],
                    ],
                    GetBlockConfigFieldsBcSubstitution::class => [
                        'class' => GetBlockConfigFieldsBcSubstitution::class,
                        'arguments' => [
                        ],
                    ],
                    GetConfigBlockComponents::class => [
                        'factory' => GetConfigBlockComponentsBcFactory::class,
                    ],
                    PrepareBlockConfig::class => [
                        'class' => PrepareBlockConfig::class,
                        'arguments' => [
                            GetBlockConfigFields::class,
                            GetBlockConfigFieldsBcSubstitution::class,
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
                        'arguments' => [
                        ],
                    ],
                    /** Content (abstracts) */
                    SearchConfigList::class => [
                        'class' => SearchConfigList::class,
                        'arguments' => [],
                    ],
                    /** ThemeComponents **/
                    FindThemeComponent::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\Theme\Api\FindThemeComponent::class,
                        'arguments' => [
                            GetConfigThemeComponents::class,
                            SearchConfigList::class
                        ],
                    ],
                    FindThemeComponentsBy::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\Theme\Api\FindThemeComponentsBy::class,
                        'arguments' => [
                            GetConfigThemeComponents::class,
                            SearchConfigList::class
                        ],
                    ],
                    GetConfigThemeComponents::class => [
                        'factory' => GetConfigThemeComponentsBasicFactory::class,
                    ],
                    ReadThemeComponentConfig::class => [
                        'factory' => ReadThemeComponentConfigBasicFactory::class,
                    ],
                    ReadThemeComponentConfigJsonFile::class => [
                        'class' => ReadThemeComponentConfigJsonFile::class,
                    ],
                    /** ViewComponents **/

                    FindViewComponent::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\View\Api\Repository\FindViewComponent::class,
                        'arguments' => [
                            GetConfigViewComponents::class,
                            SearchConfigList::class
                        ],
                    ],
                    FindViewComponentsBy::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\View\Api\Repository\FindViewComponentsBy::class,
                        'arguments' => [
                            GetConfigViewComponents::class,
                            SearchConfigList::class
                        ],
                    ],
                    GetConfigViewComponents::class => [
                        'factory' => GetConfigViewComponentsBasicFactory::class,
                    ],
                    ReadViewComponentConfigApplicationConfig::class => [
                        'factory' => ReadViewComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadViewComponentConfig::class => [
                        'factory' => ReadThemeComponentConfigBasicFactory::class,
                    ],
                    ReadViewComponentConfigJsonFile::class => [
                        'class' => ReadViewComponentConfigJsonFile::class,
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
                'views' => [
                    /*
                    '{view-name}' => '{view-location}(directory)'
                    OR
                    '{view-name}' => [
                      ComponentConfigFields::LOCATION => '{view-location}(service-name)',
                      ComponentConfigFields::COMPONENT_CONFIG_READER => '{view-location}(service-name)',
                     ]
                    */
                    ViewComponent::DEFAULT_NAME => [
                        ComponentConfigFields::LOCATION => ViewComponent::DEFAULT_NAME,
                        ComponentConfigFields::COMPONENT_CONFIG_READER => ReadViewComponentConfigApplicationConfig::class,
                        PropertiesViewComponent::LAYOUT_RENDER_DATA_GETTERS => [
                            /* '{render-tag}(optional)' => '{GetLayoutRenderData}(service-name)' */
                            PropertiesPage::RENDER_TAG => GetViewRenderDataPage::class,
                            PropertiesContainer::RENDER_TAG => GetViewRenderDataContainers::class,
                            GetViewRenderDataHead::RENDER_TAG => GetViewRenderDataHeadAll::class,
                        ],
                    ],
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
            ],
        ];
    }
}
