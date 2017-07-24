<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;
use Zrcms\ContentCore\Page\Model\PropertiesPage;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHead;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadAll;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataPage;
use Zrcms\ContentCore\View\Model\ViewComponent;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlocks;
use Zrcms\ContentCoreConfigDataSource\Block\Api\GetBlocksFactory;
use Zrcms\ContentCoreConfigDataSource\Block\Api\PrepareBlockConfig;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockConfig;
use Zrcms\ContentCoreConfigDataSource\Block\Api\ReadBlockConfigJsonFile;

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
                    SearchConfigList::class => [
                        'class' => SearchConfigList::class,
                        'arguments' => [],
                    ],
                    /** BlockComponents **/
                    // @override
                    FindBlockComponent::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\Block\Api\FindBlockComponent::class,
                        'arguments' => [
                            GetBlocks::class,
                            SearchConfigList::class
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => \Zrcms\ContentCoreConfigDataSource\Block\Api\FindBlockComponentsBy::class,
                        'arguments' => [
                            GetBlocks::class,
                            SearchConfigList::class
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
                    GetBlocks::class => [
                        'factory' => GetBlocksFactory::class,
                    ],
                    PrepareBlockConfig::class => [
                        'class' => PrepareBlockConfig::class,
                        'arguments' => [
                            GetBlockConfigFields::class,
                            GetBlockConfigFieldsBcSubstitution::class
                        ],
                    ],
                    // DEFAULT SERVICE
                    ReadBlockConfig::class => [
                        'class' => ReadBlockConfigJsonFile::class,
                        'arguments' => [
                        ],
                    ],
                    ReadBlockConfigJsonFile::class => [
                        'class' => ReadBlockConfigJsonFile::class,
                        'arguments' => [
                        ],
                    ],
                    /** ThemeComponents **/
                    /** ViewComponents **/
                ],
            ],
            'zrcms' => [
                'blocks' => [
                    /* '{block-name}' => '{block-directory}' */
                ],
                'view' => [
                    /* '{block-name}' => '{block-directory}' */
                    ViewComponent::DEFAULT_NAME => [
                        'directory' => '@todo',
                        'view-render-data-getters' => [
                            /* '{render-tag}' => '{GetLayoutRenderData-Service}' */
                            PropertiesPage::RENDER_TAG => GetViewRenderDataPage::class,
                            PropertiesContainer::RENDER_TAG => GetViewRenderDataContainers::class,
                            GetViewRenderDataHead::RENDER_TAG => GetViewRenderDataHeadAll::class,
                        ],
                    ],
                ],
                'themes' => [
                    /* '{theme-name}' => '{theme-directory}' */
                ],
            ],
        ];
    }
}
