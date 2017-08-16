<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfig;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfigFactory;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigBasic;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigJsonFile;
use Zrcms\ContentCore\Basic\Model\ServiceAliasBasic;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfig;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigBasic;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigBc;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigBcFactory;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCore\Block\Api\GetMergedConfig;
use Zrcms\ContentCore\Block\Api\GetMergedConfigBasic;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfig;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTags;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTagsBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBc;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBcFactory;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMustache;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockData;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockDataBasic;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockDataNoop;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersionLegacy;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBasic;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerBasic;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerRows;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainerLegacy;
use Zrcms\ContentCore\Container\Model\ServiceAliasContainer;
use Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource;
use Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTags;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsBasic;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsBlocks;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsHtml;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainer;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerBasic;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerRows;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceVersionBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersionsBy;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Page\Model\ServiceAliasPageContainer;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceVersionByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfig;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigBasic;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentConfig;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentConfigBasic;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTags;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutBasic;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceVersionByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Repository\InsertLayoutVersion;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ContentCore\Theme\Model\ServiceAliasTheme;
use Zrcms\ContentCore\View\Api\BuildView;
use Zrcms\ContentCore\View\Api\BuildViewCompositeFactory;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfig;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigApplicationConfig;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigApplicationConfigFactory;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigBasic;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentConfigJsonFile;
use Zrcms\ContentCore\View\Api\GetLayoutName;
use Zrcms\ContentCore\View\Api\GetLayoutNameBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTagsBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTagsContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTagsPage;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Render\RenderViewBasic;
use Zrcms\ContentCore\View\Api\Render\RenderViewLayout;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayout;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutBasic;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequestBasic;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponentsBy;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

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
                     * Basic ===========================================
                     */
                    ReadBasicComponentConfigApplicationConfig::class => [
                        'factory' => ReadBasicComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadBasicComponentConfig::class => [
                        'class' => ReadBasicComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadBasicComponentConfigJsonFile::class => [
                        'class' => ReadBasicComponentConfigJsonFile::class,
                    ],
                    /**
                     * Block ===========================================
                     */
                    GetBlockRenderTags::class => [
                        'class' => GetBlockRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetBlockData::class,
                            '1-' => GetMergedConfig::class,
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => RenderBlockBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindBlockComponent::class,
                        ],
                    ],
                    RenderBlockBc::class => [
                        'factory' => RenderBlockBcFactory::class,
                    ],
                    RenderBlockMustache::class => [
                        'arguments' => [
                            '0-' => FindBlockComponent::class,
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
                    GetBlockData::class => [
                        'class' => GetBlockDataBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindBlockComponent::class
                        ],
                    ],
                    GetBlockDataNoop::class => [],
                    GetBlockConfigFields::class => [
                        'class' => GetBlockConfigFields::class,
                    ],
                    GetBlockConfigFieldsBcSubstitution::class => [
                        'class' => GetBlockConfigFieldsBcSubstitution::class,
                    ],
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],
                    PrepareBlockConfig::class => [
                        'class' => PrepareBlockConfigBc::class,
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    PrepareBlockConfigBc::class => [
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    ReadBlockComponentConfig::class => [
                        'class' => ReadBlockComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadBlockComponentConfigBc::class => [
                        'factory' => ReadBlockComponentConfigBcFactory::class
                    ],
                    ReadBlockComponentConfigJsonFile::class => [
                        'class' => ReadBlockComponentConfigJsonFile::class,
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
                    GetContainerRenderTags::class => [
                        'class' => GetContainerRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetContainerRenderTagsBlocks::class => [
                        'arguments' => [
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderTags::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class,
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => RenderContainerBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
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
                    GetPageContainerRenderTags::class => [
                        'class' => GetPageContainerRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetPageContainerRenderTagsBlocks::class => [
                        'arguments' => [
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderTags::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class
                        ],
                    ],
                    GetPageContainerRenderTagsHtml::class => [],
                    RenderPageContainer::class => [
                        'class' => RenderPageContainerBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
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
                    GetLayoutRenderTags::class => [
                        'class' => GetLayoutRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetLayoutRenderTagsNoop::class => [],
                    RenderLayout::class => [
                        'class' => RenderLayoutBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
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
                    ReadLayoutComponentConfig::class => [
                        'class' => ReadLayoutComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadLayoutComponentConfigJsonFile::class => [
                        'class' => ReadLayoutComponentConfigJsonFile::class,
                    ],

                    ReadThemeComponentConfig::class => [
                        'class' => ReadThemeComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadThemeComponentConfigJsonFile::class => [
                        'class' => ReadThemeComponentConfigJsonFile::class,
                    ],

                    /**
                     * View ===========================================
                     */
                    GetViewLayoutTags::class => [
                        'class' => GetViewLayoutTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindViewLayoutTagsComponentsBy::class,
                        ],
                    ],
                    GetViewLayoutTagsContainers::class => [
                        'arguments' => [
                            '0-' => FindTagNamesByLayout::class,
                            '1-' => FindContainerCmsResourcesBySitePaths::class,
                            '2-' => FindContainerVersion::class,
                            '3-' => GetContainerRenderTags::class,
                            '4-' => RenderContainer::class,
                        ],
                    ],
                    GetViewLayoutTagsPage::class => [
                        'arguments' => [
                            '0-' => GetPageContainerRenderTags::class,
                            '1-' => RenderPageContainer::class,
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
                    FindTagNamesByLayout::class => [
                        'class' => FindTagNamesByLayoutBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    FindTagNamesByLayoutMustache::class => [],
                    FindViewByRequest::class => [
                        'class' => FindViewByRequestBasic::class,
                        'arguments' => [
                            '0-' => FindSiteCmsResourceVersionByHost::class,
                            '1-' => FindPageContainerCmsResourceVersionBySitePath::class,
                            '2-' => FindLayoutCmsResourceVersionByThemeNameLayoutName::class,
                            '3-' => GetLayoutName::class,
                            '4-' => FindThemeComponent::class,
                            '5-' => GetViewLayoutTags::class,
                            '6-' => RenderView::class,
                            '7-' => BuildView::class
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
                    ReadViewLayoutTagsComponentConfigApplicationConfig::class => [
                        'factory' => ReadViewLayoutTagsComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadViewLayoutTagsComponentConfig::class => [
                        'class' => ReadViewLayoutTagsComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadViewLayoutTagsComponentConfigJsonFile::class => [
                        'class' => ReadViewLayoutTagsComponentConfigJsonFile::class,
                    ],
                    BuildView::class => [
                        'factory' => BuildViewCompositeFactory::class,
                    ],
                    GetLayoutName::class => [
                        'class' => GetLayoutNameBasic::class
                    ],
                ],
            ],
            'zrcms-components' => [
            ],
            /**
             * Service Alias ===========================================
             */
            'zrcms-service-alias' => [
                /**
                 * Basic ===========================================
                 */
                /* 'zrcms.basic.component.config-reader' */
                ServiceAliasBasic::NAMESPACE_COMPONENT_CONFIG_READER => [
                    ReadBasicComponentConfigApplicationConfig::SERVICE_ALIAS
                    => ReadBasicComponentConfigApplicationConfig::class,

                    ReadBasicComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadBasicComponentConfigJsonFile::class,
                ],
                /**
                 * Block ===========================================
                 */
                ServiceAliasBlock::NAMESPACE_COMPONENT_CONFIG_READER => [
                    ReadBlockComponentConfigBc::SERVICE_ALIAS
                    => ReadBlockComponentConfigBc::class,

                    ReadBlockComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadBlockComponentConfigJsonFile::class,
                ],
                ServiceAliasBlock::NAMESPACE_CONTENT_RENDERER => [
                    'mustache'
                    => RenderBlockMustache::class,

                    RenderBlockBc::SERVICE_ALIAS
                    => RenderBlockBc::class,
                ],
                ServiceAliasBlock::NAMESPACE_CONTENT_DATA_PROVIDER => [
                    'noop'
                    => GetBlockDataNoop::class,
                ],
                /**
                 * Container ===========================================
                 */
                ServiceAliasContainer::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    'blocks'
                    => GetContainerRenderTagsBlocks::class,
                ],
                ServiceAliasContainer::NAMESPACE_CONTENT_RENDERER => [
                    'rows'
                    => RenderContainerRows::class,
                ],

                /**
                 * Page ===========================================
                 */
                ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    'blocks'
                    => GetPageContainerRenderTagsBlocks::class,

                    'html'
                    => GetPageContainerRenderTagsHtml::class,
                ],
                ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDERER => [
                    'rows'
                    => RenderPageContainerRows::class,
                ],

                /**
                 * Theme ===========================================
                 */
                ServiceAliasTheme::NAMESPACE_COMPONENT_CONFIG_READER => [
                    'json'
                    => ReadThemeComponentConfigJsonFile::class,
                ],
                // layout
                ServiceAliasLayout::NAMESPACE_COMPONENT_CONFIG_READER => [
                    'json'
                    => ReadLayoutComponentConfigJsonFile::class,
                ],
                ServiceAliasLayout::NAMESPACE_CONTENT_RENDERER => [
                    'mustache'
                    => RenderLayoutMustache::class,
                ],
                /**
                 * View ===========================================
                 */
                /* zrcms.view.content.view-layout-tags-getter */
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutTagsContainers::SERVICE_ALIAS
                    => GetViewLayoutTagsContainers::class,

                    GetViewLayoutTagsPage::SERVICE_ALIAS
                    => GetViewLayoutTagsPage::class,
                ],

                /* zrcms.view.component.view-layout-tags-config-reader */
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_CONFIG_READER => [
                    'json'
                    => ReadViewLayoutTagsComponentConfigJsonFile::class,

                    ReadViewLayoutTagsComponentConfigApplicationConfig::SERVICE_ALIAS
                    => ReadViewLayoutTagsComponentConfigApplicationConfig::class,
                ],

                ServiceAliasView::NAMESPACE_CONTENT_RENDERER => [
                    'layout' => RenderViewLayout::class,
                ],

                ServiceAliasView::NAMESPACE_LAYOUT_TAG_NAME_PARSER => [
                    'mustache' => FindTagNamesByLayoutMustache::class
                ],
            ],
            'zrcms-view-builders' => [
                // 'key (optional)' => '{service-name}'
            ],
        ];
    }
}
