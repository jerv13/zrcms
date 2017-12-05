<?php

namespace Zrcms\ContentCore;

use Zrcms\Content\Api\Component\BuildComponentObject;
use Zrcms\Content\Api\Component\BuildComponentObjectDefault;
use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\Content\Api\Component\PrepareComponentConfig;
use Zrcms\Content\Api\Component\PrepareComponentConfigNoop;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTags;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\View\Api\BuildView;
use Zrcms\ContentCore\View\Api\BuildViewCompositeFactory;
use Zrcms\ContentCore\View\Api\GetLayoutName;
use Zrcms\ContentCore\View\Api\GetLayoutNameBasic;
use Zrcms\ContentCore\View\Api\GetRegisterViewLayoutTagsComponents;
use Zrcms\ContentCore\View\Api\GetTagNamesByLayout;
use Zrcms\ContentCore\View\Api\GetTagNamesByLayoutBasic;
use Zrcms\ContentCore\View\Api\GetTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\GetViewByRequestBasic;
use Zrcms\ContentCore\View\Api\GetViewByRequestHtmlPage;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTagsBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTagsContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTagsPage;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Render\RenderViewBasic;
use Zrcms\ContentCore\View\Api\Render\RenderViewLayout;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponentBasic;
use Zrcms\HttpContent\Component\FindComponentsBy;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigView
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
