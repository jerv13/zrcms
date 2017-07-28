<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Block\Api\GetMergedConfig;
use Zrcms\ContentCore\Block\Api\GetMergedConfigBasic;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderData;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderDataBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBasicFactory;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMustache;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockVersionsByContainer;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockData;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockDataBasicFactory;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockDataNoop;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersionLegacy;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderData;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderDataBasicFactory;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderDataBlocks;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerBasicFactory;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerRows;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainerLegacy;
use Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource;
use Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderData;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderDataBasicFactory;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderDataBlocks;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderDataHtml;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainer;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerBasicFactory;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerRows;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersionsBy;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderData;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderDataBasicFactory;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderDataNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutBasicFactory;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Repository\InsertLayoutVersion;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataBasicFactory;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHead;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadAll;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadAllFactory;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadLink;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadMeta;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadScript;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataHeadTitle;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderDataPage;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Render\RenderViewBasicFactory;
use Zrcms\ContentCore\View\Api\Render\RenderViewLayout;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayout;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutBasicFactory;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequestBasic;
use Zrcms\ContentCore\View\Api\Repository\FindViewComponent;
use Zrcms\ContentCore\View\Api\Repository\FindViewComponentsBy;

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

                    /**
                     * Block ===========================================
                     */
                    GetBlockRenderData::class => [
                        'class' => GetBlockRenderDataBasic::class,
                        'arguments' => [
                            '0-' => GetBlockData::class,
                            '1-' => GetMergedConfig::class,
                        ],
                    ],
                    RenderBlock::class => [
                        'factory' => RenderBlockBasicFactory::class,
                    ],
                    RenderBlockMustache::class => [
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],
                    FindBlockComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockComponent::class],
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockComponentsBy::class],
                        ],
                    ],
                    FindBlockVersionsByContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockVersionsByContainer::class],
                        ],
                    ],
                    GetBlockData::class => [
                        'factory' => GetBlockDataBasicFactory::class,
                    ],
                    GetBlockDataNoop::class => [],
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                    ],
                    WrapRenderedBlockVersion::class => [
                        'class' => WrapRenderedBlockVersionLegacy::class,
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],

                    /**
                     * Container ===========================================
                     */
                    PublishContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishContainerCmsResource::class],
                        ],
                    ],
                    UnpublishContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishContainerCmsResource::class],
                        ],
                    ],
                    GetContainerRenderData::class => [
                        'factory' => GetContainerRenderDataBasicFactory::class,
                    ],
                    GetContainerRenderDataBlocks::class => [
                        'arguments' => [
                            '0-' => FindBlockVersionsByContainer::class,
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderData::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class,
                        ],
                    ],
                    RenderContainer::class => [
                        'factory' => RenderContainerBasicFactory::class,
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

                    /**
                     * Page ===========================================
                     */
                    PublishPageContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishPageContainerCmsResource::class],
                        ],
                    ],
                    UnpublishPageContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishPageContainerCmsResource::class],
                        ],
                    ],
                    GetPageContainerRenderData::class => [
                        'factory' => GetPageContainerRenderDataBasicFactory::class,
                    ],
                    GetPageContainerRenderDataBlocks::class => [
                        'arguments' => [
                            '0-' => FindBlockVersionsByContainer::class,
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderData::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class
                        ],
                    ],
                    GetPageContainerRenderDataHtml::class => [],
                    RenderPageContainer::class => [
                        'factory' => RenderPageContainerBasicFactory::class,
                    ],
                    RenderPageContainerRows::class => [
                        'arguments' => [
                            '0-' => RenderBlock::class,
                            '1-' => WrapRenderedContainer::class
                        ],
                    ],
                    FindPageContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerCmsResource::class],
                        ],
                    ],
                    FindPageContainerCmsResourceBySitePath::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerCmsResourceBySitePath::class],
                        ],
                    ],
                    FindPageContainerCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerCmsResourcesBy::class],
                        ],
                    ],
                    FindPageContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerVersion::class],
                        ],
                    ],
                    FindPageContainerVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerVersionsBy::class],
                        ],
                    ],
                    InsertPageContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertPageContainerVersion::class],
                        ],
                    ],
                    /**
                     * Site ===========================================
                     */
                    PublishSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishSiteCmsResource::class],
                        ],
                    ],
                    UnpublishSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishSiteCmsResource::class],
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResource::class],
                        ],
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResourceByHost::class],
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResourcesBy::class],
                        ],
                    ],
                    FindSiteVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteVersion::class],
                        ],
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteVersionsBy::class],
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertSiteVersion::class],
                        ],
                    ],

                    /**
                     * Theme ===========================================
                     */
                    PublishLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishLayoutCmsResource::class],
                        ],
                    ],
                    UnpublishLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishLayoutCmsResource::class],
                        ],
                    ],
                    GetLayoutRenderData::class => [
                        'factory' => GetLayoutRenderDataBasicFactory::class,
                    ],
                    GetLayoutRenderDataNoop::class => [],
                    RenderLayout::class => [
                        'factory' => RenderLayoutBasicFactory::class,
                    ],
                    RenderLayoutMustache::class => [],
                    FindLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutCmsResource::class],
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutCmsResourceByThemeNameLayoutName::class],
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutCmsResourcesBy::class],
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutVersion::class],
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutVersionsBy::class],
                        ],
                    ],
                    FindThemeComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindThemeComponent::class],
                        ],
                    ],
                    FindThemeComponentsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindThemeComponentsBy::class],
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertLayoutVersion::class],
                        ],
                    ],
                    /**
                     * View ===========================================
                     */
                    GetViewRenderData::class => [
                        'factory' => GetViewRenderDataBasicFactory::class,
                    ],
                    GetViewRenderDataContainers::class => [
                        'arguments' => [
                            '0-' => FindTagNamesByLayout::class,
                            '1-' => FindContainerCmsResourcesBySitePaths::class,
                            '2-' => FindContainerVersion::class,
                            '3-' => GetContainerRenderData::class
                        ],
                    ],
                    GetViewRenderDataHead::class => [
                        'factory' => GetViewRenderDataHeadAllFactory::class,
                    ],
                    GetViewRenderDataHeadAll::class => [
                        'factory' => GetViewRenderDataHeadAllFactory::class,
                    ],
                    GetViewRenderDataHeadLink::class => [],
                    GetViewRenderDataHeadMeta::class => [],
                    GetViewRenderDataHeadScript::class => [],
                    GetViewRenderDataHeadTitle::class => [],
                    GetViewRenderDataPage::class => [
                        'arguments' => [
                            '0-' => GetPageContainerRenderData::class,
                            '1-' => RenderPageContainer::class,
                        ],
                    ],
                    RenderView::class => [
                        'factory' => RenderViewBasicFactory::class,
                    ],
                    RenderViewLayout::class => [
                        'arguments' => [
                            '0-' => RenderLayout::class,
                        ],
                    ],
                    FindTagNamesByLayout::class => [
                        'factory' => FindTagNamesByLayoutBasicFactory::class,
                    ],
                    FindTagNamesByLayoutMustache::class => [],
                    FindViewByRequest::class => [
                        'class' => FindViewByRequestBasic::class,
                        'arguments' => [
                            '0-' => FindSiteCmsResourceByHost::class,
                            '1-' => FindSiteVersion::class,
                            '2-' => FindPageContainerCmsResourceBySitePath::class,
                            '3-' => FindPageContainerVersion::class,
                            '4-' => FindLayoutCmsResourceByThemeNameLayoutName::class,
                            '5-' => FindLayoutVersion::class,
                            '6-' => FindThemeComponent::class,
                            '7-' => GetViewRenderData::class,
                            '8-' => RenderView::class
                        ],
                    ],
                    FindViewComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindViewComponent::class],
                        ],
                    ],
                    FindViewComponentsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindViewComponentsBy::class],
                        ],
                    ],
                ],
            ],
            'zrcms' => [
            ],
        ];
    }
}
