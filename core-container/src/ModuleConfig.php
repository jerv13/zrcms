<?php

namespace Zrcms\CoreContainer;

use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTagsBasic;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CoreContainer\Api\Render\RenderContainerBasic;
use Zrcms\CoreContainer\Api\Render\RenderContainerRows;
use Zrcms\CoreContainer\Api\Render\WrapRenderedContainer;
use Zrcms\CoreContainer\Api\Render\WrapRenderedContainerLegacy;
use Zrcms\Debug\IsDebug;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Render
                     */
                    GetContainerRenderTags::class => [
                        'class' => GetContainerRenderTagsBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetContainerRenderTagsBlocks::class => [
                        'arguments' => [
                            RenderBlock::class,
                            GetBlockRenderTags::class,
                            WrapRenderedBlockVersion::class,
                            WrapRenderedContainer::class,
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => RenderContainerBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    RenderContainerRows::class => [
                        'arguments' => [
                            RenderBlock::class,
                            WrapRenderedContainer::class,
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    WrapRenderedContainer::class => [
                        'class' => WrapRenderedContainerLegacy::class,
                    ],
                    WrapRenderedContainerLegacy::class => [],
                ],
            ],
        ];
    }
}
