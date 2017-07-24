<?php

namespace Zrcms\CoreConfigDataSource;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;
use Zrcms\ContentCore\Page\Model\PropertiesPage;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHead;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadAll;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataPage;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlockConfigFields;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlocks;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlocksFactory;
use Zrcms\CoreConfigDataSource\Block\Api\PrepareBlockConfig;
use Zrcms\CoreConfigDataSource\Block\Api\ReadBlockConfig;
use Zrcms\CoreConfigDataSource\Block\Api\ReadBlockConfigJsonFile;

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
                        'class' => \Zrcms\CoreConfigDataSource\Block\Api\FindBlockComponent::class,
                        'arguments' => [
                            GetBlocks::class,
                            SearchConfigList::class
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => \Zrcms\CoreConfigDataSource\Block\Api\FindBlockComponentsBy::class,
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
                    'name' => 'default',
                    'directory' => '@todo',
                    'view-render-data-getters' => [
                        /* '{render-tag}' => '{GetLayoutRenderData-Service}' */
                        PropertiesPage::RENDER_TAG => GetViewRenderDataPage::class,
                        PropertiesContainer::RENDER_TAG => GetViewRenderDataContainers::class,
                        GetViewRenderDataHead::RENDER_TAG => GetViewRenderDataHeadAll::class,
                    ],
                ],
                'themes' => [
                    /* '{theme-name}' => '{theme-directory}' */
                ],
            ],
        ];
    }
}
