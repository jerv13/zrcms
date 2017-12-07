<?php

namespace Zrcms\CoreView;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\BuildComponentObjectDefault;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\PrepareComponentConfig;
use Zrcms\Core\Api\Component\PrepareComponentConfigNoop;
use Zrcms\CoreApplication\Api\ApiNoop;
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
use Zrcms\CoreView\Api\GetRegisterViewLayoutTagsComponents;
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
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindComponentsBy::class,
                        ],
                    ],
                    GetViewLayoutTagsContainers::class => [
                        'arguments' => [
                            '0-' => GetTagNamesByLayout::class,
                            '1-' => FindContainerCmsResourcesBySitePaths::class,
                            '2-' => GetContainerRenderTags::class,
                            '3-' => RenderContainer::class,
                        ],
                    ],
                    GetViewLayoutTagsPage::class => [
                        'arguments' => [
                            '0-' => GetPageRenderTags::class
                        ],
                    ],
                    RenderView::class => [
                        'class' => RenderViewBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    RenderViewLayout::class => [
                        'arguments' => [
                            '0-' => RenderLayout::class,
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
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetTagNamesByLayoutMustache::class => [],
                    GetViewByRequest::class => [
                        'class' => GetViewByRequestBasic::class,
                        'arguments' => [
                            '0-' => FindSiteCmsResourceByHost::class,
                            '1-' => FindPageCmsResourceBySitePath::class,
                            '2-' => FindLayoutCmsResourceByThemeNameLayoutName::class,
                            '3-' => GetLayoutName::class,
                            '4-' => FindComponent::class,
                            '5-' => GetViewLayoutTags::class,
                            '6-' => BuildView::class
                        ],
                    ],
                    GetViewByRequestHtmlPage::class => [
                        'arguments' => [
                            '0-' => FindSiteCmsResourceByHost::class,
                            '1-' => FindPageCmsResourceBySitePath::class,
                            '2-' => FindLayoutCmsResourceByThemeNameLayoutName::class,
                            '3-' => GetLayoutName::class,
                            '4-' => FindComponent::class,
                            '5-' => GetViewLayoutTags::class,
                            '6-' => BuildView::class,
                        ],
                    ],
                    GetLayoutName::class => [
                        'class' => GetLayoutNameBasic::class
                    ],
                    GetRegisterViewLayoutTagsComponents::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => GetRegisterViewLayoutTagsComponents::class],
                        ],
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
                    BuildComponentObject::class => BuildComponentObjectDefault::class,
                    PrepareComponentConfig::class => PrepareComponentConfigNoop::class,
                    'component-model-interface' => ViewLayoutTagsComponent::class,
                    'component-model-class' => ViewLayoutTagsComponentBasic::class,
                ]
            ],
        ];
    }
}
