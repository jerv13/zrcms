<?php

namespace Zrcms\CoreView;

use Zrcms\CoreView\Api\GetApplicationStateView;
use Zrcms\CoreView\Api\GetApplicationStateViewFactory;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutCmsResourceBasicFactory;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetLayoutNameBasicFactory;
use Zrcms\CoreView\Api\GetPageCmsResource;
use Zrcms\CoreView\Api\GetPageCmsResourceBasicFactory;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetSiteCmsResourceBasicFactory;
use Zrcms\CoreView\Api\GetTagNamesByLayout;
use Zrcms\CoreView\Api\GetTagNamesByLayoutBasicFactory;
use Zrcms\CoreView\Api\GetTagNamesByLayoutMustache;
use Zrcms\CoreView\Api\GetThemeName;
use Zrcms\CoreView\Api\GetThemeNameBasicFactory;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\GetViewByRequestDefaultFactory;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsBasicFactory;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsContainers;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsContainersFactory;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsPage;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsPageFactory;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Api\Render\RenderViewBasicFactory;
use Zrcms\CoreView\Api\Render\RenderViewLayout;
use Zrcms\CoreView\Api\Render\RenderViewLayoutFactory;
use Zrcms\CoreView\Api\ViewBuilder\BuildRequestedView;
use Zrcms\CoreView\Api\ViewBuilder\BuildRequestedViewByConfigFactory;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewDefault;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewDefaultFactory;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewDefaultPublishedAny;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewDefaultPublishedAnyFactory;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewHtmlPage;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewHtmlPageFactory;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewPageVersionId;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewPageVersionIdFactory;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategy;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyCompositeFactory;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyDefault;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyDefaultFactory;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyDefaultPublishedAny;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyDefaultPublishedAnyFactory;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyHtmlPage;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyHtmlPageFactory;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyPageVersionId;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyPageVersionIdFactory;
use Zrcms\CoreView\Api\ViewBuilder\MutateView;
use Zrcms\CoreView\Api\ViewBuilder\MutateViewCompositeFactory;
use Zrcms\CoreView\Api\ViewToArray;
use Zrcms\CoreView\Api\ViewToArrayBasicFactory;

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
                     * Api/Render
                     */
                    GetViewLayoutTags::class => [
                        'factory' => GetViewLayoutTagsBasicFactory::class,
                    ],
                    GetViewLayoutTagsContainers::class => [
                        'factory' => GetViewLayoutTagsContainersFactory::class,
                    ],
                    GetViewLayoutTagsPage::class => [
                        'factory' => GetViewLayoutTagsPageFactory::class,
                    ],
                    RenderView::class => [
                        'factory' => RenderViewBasicFactory::class,
                    ],
                    RenderViewLayout::class => [
                        'factory' => RenderViewLayoutFactory::class,
                    ],

                    /**
                     * Api/ViewBuilder
                     */
                    BuildRequestedView::class => [
                        'factory' => BuildRequestedViewByConfigFactory::class,
                    ],
                    BuildViewDefault::class => [
                        'factory' => BuildViewDefaultFactory::class,
                    ],
                    BuildViewDefaultPublishedAny::class => [
                        'factory' => BuildViewDefaultPublishedAnyFactory::class,
                    ],
                    BuildViewHtmlPage::class => [
                        'factory' => BuildViewHtmlPageFactory::class,
                    ],
                    BuildViewPageVersionId::class => [
                        'factory' => BuildViewPageVersionIdFactory::class,
                    ],
                    DetermineViewStrategy::class => [
                        'factory' => DetermineViewStrategyCompositeFactory::class,
                    ],
                    DetermineViewStrategyDefault::class => [
                        'factory' => DetermineViewStrategyDefaultFactory::class,
                    ],
                    DetermineViewStrategyDefaultPublishedAny::class => [
                        'factory' => DetermineViewStrategyDefaultPublishedAnyFactory::class,
                    ],
                    DetermineViewStrategyHtmlPage::class => [
                        'factory' => DetermineViewStrategyHtmlPageFactory::class,
                    ],
                    DetermineViewStrategyPageVersionId::class => [
                        'factory' => DetermineViewStrategyPageVersionIdFactory::class,
                    ],
                    MutateView::class => [
                        'factory' => MutateViewCompositeFactory::class,
                    ],

                    /**
                     * Api
                     */
                    GetApplicationStateView::class => [
                        'factory' => GetApplicationStateViewFactory::class,
                    ],
                    GetLayoutCmsResource::class => [
                        'factory' => GetLayoutCmsResourceBasicFactory::class,
                    ],
                    GetLayoutName::class => [
                        'factory' => GetLayoutNameBasicFactory::class
                    ],
                    GetPageCmsResource::class => [
                        'factory' => GetPageCmsResourceBasicFactory::class,
                    ],
                    GetSiteCmsResource::class => [
                        'factory' => GetSiteCmsResourceBasicFactory::class,
                    ],
                    GetTagNamesByLayout::class => [
                        'factory' => GetTagNamesByLayoutBasicFactory::class
                    ],
                    GetTagNamesByLayoutMustache::class => [],
                    GetThemeName::class => [
                        'factory' => GetThemeNameBasicFactory::class,
                    ],
                    GetViewByRequest::class => [
                        'factory' => GetViewByRequestDefaultFactory::class,
                    ],
                    ViewToArray::class => [
                        'factory' => ViewToArrayBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
