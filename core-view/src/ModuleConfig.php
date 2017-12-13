<?php

namespace Zrcms\CoreView;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByType;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\CoreTheme\Api\Render\RenderLayout;
use Zrcms\CoreView\Api\BuildView;
use Zrcms\CoreView\Api\BuildViewCompositeFactory;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetLayoutNameBasic;
use Zrcms\CoreView\Api\GetTagNamesByLayout;
use Zrcms\CoreView\Api\GetTagNamesByLayoutBasic;
use Zrcms\CoreView\Api\GetTagNamesByLayoutMustache;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\GetViewByRequestBasic;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPage;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsBasic;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsContainers;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsPage;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Api\Render\RenderViewBasic;
use Zrcms\CoreView\Api\Render\RenderViewLayout;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\ViewLayoutTagsComponent;
use Zrcms\CoreView\Model\ViewLayoutTagsComponentBasic;
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
                    GetTagNamesByLayout::class => [
                        'class' => GetTagNamesByLayoutBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetTagNamesByLayoutMustache::class => [],
                    GetViewByRequest::class => [
                        'class' => GetViewByRequestBasic::class,
                        'arguments' => [
                            FindSiteCmsResourceByHost::class,
                            FindPageCmsResourceBySitePath::class,
                            FindLayoutCmsResourceByThemeNameLayoutName::class,
                            GetLayoutName::class,
                            FindComponent::class,
                            GetViewLayoutTags::class,
                            BuildView::class
                        ],
                    ],
                    GetViewByRequestHtmlPage::class => [
                        'arguments' => [
                            FindSiteCmsResourceByHost::class,
                            FindPageCmsResourceBySitePath::class,
                            FindLayoutCmsResourceByThemeNameLayoutName::class,
                            GetLayoutName::class,
                            FindComponent::class,
                            GetViewLayoutTags::class,
                            BuildView::class,
                        ],
                    ],
                    GetLayoutName::class => [
                        'class' => GetLayoutNameBasic::class
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.view.content.view-layout-tags-getter'
                ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutTagsContainers::SERVICE_ALIAS
                    => GetViewLayoutTagsContainers::class,

                    GetViewLayoutTagsPage::SERVICE_ALIAS
                    => GetViewLayoutTagsPage::class,
                ],
                // 'zrcms.view.content.renderer'
                ServiceAliasView::ZRCMS_CONTENT_RENDERER => [
                    'layout' => RenderViewLayout::class,
                ],
                // 'zrcms.view.layout.tag-name-parser'
                ServiceAliasView::ZRCMS_LAYOUT_TAG_NAME_PARSER => [
                    'mustache' => GetTagNamesByLayoutMustache::class
                ],
            ],
            /**
             * @todo This should be a View component
             * ===== View builders registry =====
             */
            'zrcms-view-builders' => [
                // 'key (optional)' => '{service-name}'
            ],

            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                'view-layout-tag' => [
                    BuildComponentObject::class => BuildComponentObjectByType::class,
                    'component-model-interface' => ViewLayoutTagsComponent::class,
                    'component-model-class' => ViewLayoutTagsComponentBasic::class,
                ]
            ],
        ];
    }
}
