<?php

namespace Zrcms\CoreView;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CoreTheme\Api\Render\RenderLayout;
use Zrcms\CoreView\Api\BuildView;
use Zrcms\CoreView\Api\BuildViewCompositeFactory;
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
use Zrcms\CoreView\Api\GetTagNamesByLayoutBasic;
use Zrcms\CoreView\Api\GetTagNamesByLayoutMustache;
use Zrcms\CoreView\Api\GetThemeName;
use Zrcms\CoreView\Api\GetThemeNameBasicFactory;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\GetViewByRequestBasic;
use Zrcms\CoreView\Api\GetViewByRequestBasicFactory;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPage;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPageFactory;
use Zrcms\CoreView\Api\GetViewByRequestStrategyFactory;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsBasic;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsContainers;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsPage;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Api\Render\RenderViewBasic;
use Zrcms\CoreView\Api\Render\RenderViewLayout;
use Zrcms\CoreView\Api\ViewToArray;
use Zrcms\CoreView\Api\ViewToArrayBasicFactory;
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
                    GetViewLayoutTags::class => [
                        'class' => GetViewLayoutTagsBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                            FindComponentsBy::class,
                        ],
                    ],
                    GetViewLayoutTagsContainers::class => [
                        'arguments' => [
                            GetTagNamesByLayout::class,
                            FindContainerCmsResourcesBySitePaths::class,
                            GetContainerRenderTags::class,
                            RenderContainer::class,
                        ],
                    ],
                    GetViewLayoutTagsPage::class => [
                        'arguments' => [
                            GetPageRenderTags::class
                        ],
                    ],
                    RenderView::class => [
                        'class' => RenderViewBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    RenderViewLayout::class => [
                        'arguments' => [
                            RenderLayout::class,
                        ],
                    ],
                    /**
                     * Api
                     */
                    BuildView::class => [
                        'factory' => BuildViewCompositeFactory::class,
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
                        'class' => GetTagNamesByLayoutBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetTagNamesByLayoutMustache::class => [],
                    GetThemeName::class => [
                        'factory' => GetThemeNameBasicFactory::class,
                    ],

                    GetViewByRequest::class => [
                        'factory' => GetViewByRequestStrategyFactory::class,
                    ],
                    GetViewByRequestBasic::class => [
                        'factory' => GetViewByRequestBasicFactory::class,
                    ],
                    GetViewByRequestHtmlPage::class => [
                        'factory' => GetViewByRequestHtmlPageFactory::class,
                    ],

                    ViewToArray::class => [
                        'factory' => ViewToArrayBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
