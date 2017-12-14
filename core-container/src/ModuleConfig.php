<?php

namespace Zrcms\CoreContainer;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CoreContainer\Api\Content\FindContainerVersion;
use Zrcms\CoreContainer\Api\Content\FindContainerVersionsBy;
use Zrcms\CoreContainer\Api\Content\InsertContainerVersion;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTagsBasic;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CoreContainer\Api\Render\RenderContainerBasic;
use Zrcms\CoreContainer\Api\Render\RenderContainerRows;
use Zrcms\CoreContainer\Api\Render\WrapRenderedContainer;
use Zrcms\CoreContainer\Api\Render\WrapRenderedContainerLegacy;
use Zrcms\CoreContainer\Model\ServiceAliasContainer;
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
                    UpsertContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
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
                            WrapRenderedContainer::class
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResourcesBySitePaths::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertContainerVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
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
                    'block'
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
