<?php

namespace Zrcms\CoreContainer;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreContainer\Api\CmsResource\CreateContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySiteNames;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesPublished;
use Zrcms\CoreContainer\Api\CmsResource\UpdateContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResourceHistory\FindContainerCmsResourceHistory;
use Zrcms\CoreContainer\Api\CmsResourceHistory\FindContainerCmsResourceHistoryBy;
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
                     * CmsResource
                     */
                    CreateContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResourcesBySiteNames::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpdateContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    FindContainerCmsResourceHistory::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerCmsResourceHistoryBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * ContentVersion
                     */
                    FindContainerVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertContainerVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

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
