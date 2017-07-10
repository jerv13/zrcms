<?php

namespace Zrcms\Core;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Api\FindBlocksBy;
use Zrcms\Core\Block\Api\RenderBlock;
use Zrcms\Core\BlockInstance\Api\GetMergedConfig;
use Zrcms\Core\BlockInstance\Api\GetMergedConfigBasic;
use Zrcms\Core\BlockInstance\Api\RenderBlockInstance;
use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Container\Api\GetContainerUri;
use Zrcms\Core\Container\Api\GetContainerUriBasic;
use Zrcms\Core\Container\Api\RenderContainer;

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
                    FindBlock::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    FindBlocksBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                        'arguments' => [
                        ],
                    ],
                    RenderBlockInstance::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    CreateContainerPublished::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    GetContainerUri::class => [
                        'class' => GetContainerUriBasic::class,
                        'arguments' => [
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                ]
            ]
        ];
    }
}
