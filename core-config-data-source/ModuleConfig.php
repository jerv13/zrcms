<?php

namespace Zrcms\CoreConfigDataSource;

use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlockConfigFields;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlocks;
use Zrcms\CoreConfigDataSource\Block\Api\GetBlocksFactory;
use Zrcms\CoreConfigDataSource\Block\Api\PrepareBlockConfig;
use Zrcms\CoreConfigDataSource\Block\Api\ReadBlockConfig;
use Zrcms\CoreConfigDataSource\Block\Api\ReadBlockConfigJsonFile;
use Zrcms\CoreConfigDataSource\Block\Api\SearchBlockList;

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
                    // 'blockName' => 'blockDirectory'
                ],
                'layout-render-data-getters' => [
                    // 'GetLayoutRenderData Service'
                ],
                'themes' => [
                    // 'themeName' => 'themeDirectory'
                ],
            ],
        ];
    }
}
