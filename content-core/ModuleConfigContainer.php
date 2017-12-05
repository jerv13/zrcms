<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTags;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Render\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Container\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBasic;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerBasic;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerRows;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Content\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Content\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Content\InsertContainerVersion;
use Zrcms\ContentCore\Container\Api\Render\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Api\Render\WrapRenderedContainerLegacy;
use Zrcms\ContentCore\Container\Model\ServiceAliasContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigContainer
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    UpsertContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertContainerCmsResource::class],
                        ],
                    ],
                    GetContainerRenderTags::class => [
                        'class' => GetContainerRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetContainerRenderTagsBlocks::class => [
                        'arguments' => [
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderTags::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class,
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => RenderContainerBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    RenderContainerRows::class => [
                        'arguments' => [
                            '0-' => RenderBlock::class,
                            '1-' => WrapRenderedContainer::class
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerCmsResource::class],
                        ],
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerCmsResourcesBy::class],
                        ],
                    ],
                    FindContainerCmsResourcesBySitePaths::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerCmsResourcesBySitePaths::class],
                        ],
                    ],
                    FindContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerVersion::class],
                        ],
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerVersionsBy::class],
                        ],
                    ],
                    InsertContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertContainerVersion::class],
                        ],
                    ],
                    WrapRenderedContainer::class => [
                        'class' => WrapRenderedContainerLegacy::class,
                    ],
                    WrapRenderedContainerLegacy::class => [],

                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.container.content.render-tags-getter'
                ServiceAliasContainer::ZRCMS_CONTENT_RENDER_TAGS_GETTER => [
                    'blocks'
                    => GetContainerRenderTagsBlocks::class,
                ],
                // 'zrcms.container.content.renderer'
                ServiceAliasContainer::ZRCMS_CONTENT_RENDERER => [
                    'rows'
                    => RenderContainerRows::class,
                ],
            ],
        ];
    }
}
