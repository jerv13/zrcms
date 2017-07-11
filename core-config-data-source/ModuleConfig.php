<?php

namespace Zrcms\CoreConfigDataSource;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Api\FindBlocksBy;
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
                    /** Api **/
                    // @override
                    FindBlock::class => [
                        'class' => \Zrcms\CoreConfigDataSource\Block\Api\FindBlock::class,
                        'arguments' => [
                            GetBlocks::class,
                            SearchBlockList::class
                        ],
                    ],
                    FindBlocksBy::class => [
                        'class' => \Zrcms\CoreConfigDataSource\Block\Api\FindBlocksBy::class,
                        'arguments' => [
                            GetBlocks::class,
                            SearchBlockList::class
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
                    SearchBlockList::class => [
                        'class' => SearchBlockList::class,
                        'arguments' => [
                        ],
                    ],
                ],
            ],
            'zrcms' => [
                'blocks' => [
                    // 'blockName' => 'blockDirectory'
                ],
            ],
        ];
    }
}
