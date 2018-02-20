<?php

namespace Zrcms\CoreView;

use Zrcms\CoreView\Api\BuildView;
use Zrcms\CoreView\Api\BuildViewBasicFactory;
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
use Zrcms\CoreView\Api\GetViewByRequestBasic;
use Zrcms\CoreView\Api\GetViewByRequestBasicFactory;
use Zrcms\CoreView\Api\GetViewByRequestByPageVersion;
use Zrcms\CoreView\Api\GetViewByRequestByPageVersionFactory;
use Zrcms\CoreView\Api\GetViewByRequestCompositeFactory;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPage;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPageFactory;
use Zrcms\CoreView\Api\MutateView;
use Zrcms\CoreView\Api\MutateViewCompositeFactory;
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
                     * Api
                     */
                    BuildView::class => [
                        'factory' => BuildViewBasicFactory::class,
                    ],
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
                        'factory' => GetViewByRequestCompositeFactory::class,
                    ],

                    GetViewByRequestBasic::class => [
                        'factory' => GetViewByRequestBasicFactory::class,
                    ],
                    GetViewByRequestByPageVersion::class => [
                        'factory' => GetViewByRequestByPageVersionFactory::class,
                    ],
                    GetViewByRequestHtmlPage::class => [
                        'factory' => GetViewByRequestHtmlPageFactory::class,
                    ],

                    MutateView::class => [
                        'factory' => MutateViewCompositeFactory::class,
                    ],

                    ViewToArray::class => [
                        'factory' => ViewToArrayBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
