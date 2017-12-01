<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTags;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponent;
use Zrcms\ContentCore\View\Api\BuildView;
use Zrcms\ContentCore\View\Api\BuildViewCompositeFactory;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfig;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigApplicationConfig;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigApplicationConfigFactory;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigByStrategy;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigJsonFile;
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
use Zrcms\ContentCore\View\Api\Component\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Api\Component\FindViewLayoutTagsComponentsBy;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
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
                    ReadViewLayoutTagsComponentConfigApplicationConfig::class => [
                        'factory' => ReadViewLayoutTagsComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadViewLayoutTagsComponentConfig::class => [
                        'class' => ReadViewLayoutTagsComponentConfigByStrategy::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadViewLayoutTagsComponentConfigJsonFile::class => [
                        'class' => ReadViewLayoutTagsComponentConfigJsonFile::class,
                    ],
                    GetViewLayoutTags::class => [
                        'class' => GetViewLayoutTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindViewLayoutTagsComponentsBy::class,
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
                            '4-' => FindThemeComponent::class,
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
                            '4-' => FindThemeComponent::class,
                            '5-' => GetViewLayoutTags::class,
                            '6-' => BuildView::class,
                        ],
                    ],
                    FindViewLayoutTagsComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindViewLayoutTagsComponent::class],
                        ],
                    ],
                    FindViewLayoutTagsComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindViewLayoutTagsComponent::class],
                        ],
                    ],
                    BuildView::class => [
                        'factory' => BuildViewCompositeFactory::class,
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
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutTagsContainers::SERVICE_ALIAS
                    => GetViewLayoutTagsContainers::class,

                    GetViewLayoutTagsPage::SERVICE_ALIAS
                    => GetViewLayoutTagsPage::class,
                ],

                // 'zrcms.view.component.view-layout-tags-config-reader' */
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_CONFIG_READER => [
                    'json'
                    => ReadViewLayoutTagsComponentConfigJsonFile::class,

                    ReadViewLayoutTagsComponentConfigApplicationConfig::SERVICE_ALIAS
                    => ReadViewLayoutTagsComponentConfigApplicationConfig::class,
                ],
                // 'zrcms.view.content.renderer'
                ServiceAliasView::NAMESPACE_CONTENT_RENDERER => [
                    'layout' => RenderViewLayout::class,
                ],
                // 'zrcms.view.layout.tag-name-parser'
                ServiceAliasView::NAMESPACE_LAYOUT_TAG_NAME_PARSER => [
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
        ];
    }
}
