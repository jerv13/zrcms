<?php

namespace Zrcms\ViewHead;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\Debug\IsDebug;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ViewHead\Api\Component\ReadViewHeadComponentConfigBc;
use Zrcms\ViewHead\Api\Component\ReadViewHeadComponentConfigBcFactory;
use Zrcms\ViewHead\Api\GetAvailableHeadSections;
use Zrcms\ViewHead\Api\GetAvailableHeadSectionsFactory;
use Zrcms\ViewHead\Api\GetSections;
use Zrcms\ViewHead\Api\GetSectionsHeadSectionComponent;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHead;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadAll;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadLink;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadMeta;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadScript;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadTitle;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTag;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTagBasic;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTag;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagBasic;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagFileIncludes;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagLiteral;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagServiceAliasStrategy;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagViewLayoutTags;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagWithRenderService;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionTagWithRenderServiceFactory;
use Zrcms\ViewHead\Model\ServiceAliasViewHead;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTags;

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
                     * API ========================================
                     */
                    GetViewLayoutTagsHead::class => [
                        'class' => GetViewLayoutTagsHeadAll::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadAll::class => [
                        'class' => GetViewLayoutTagsHeadAll::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadLink::class => [
                        'arguments' => [
                            GetSections::class,
                            RenderHeadSectionsTag::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadMeta::class => [
                        'arguments' => [
                            FindComponent::class,
                            RenderTags::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadScript::class => [
                        'arguments' => [
                            GetSections::class,
                            RenderHeadSectionsTag::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadTitle::class => [],
                    RenderHeadSectionsTag::class => [
                        'class' => RenderHeadSectionsTagBasic::class,
                        'arguments' => [
                            GetAvailableHeadSections::class,
                            RenderHeadSectionTag::class,
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    RenderHeadSectionTag::class => [
                        'class' => RenderHeadSectionTagServiceAliasStrategy::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                            ['literal' => ServiceAliasViewHead::ZRCMS_VIEW_HEAD_RENDER_HEAD_SECTION_TAG],
                            ['literal' => RenderHeadSectionTagBasic::SERVICE_ALIAS],
                        ],
                    ],
                    RenderHeadSectionTagBasic::class => [
                        'arguments' => [
                            RenderTag::class,
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    RenderHeadSectionTagFileIncludes::class => [
                        'arguments' => [
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    RenderHeadSectionTagLiteral::class => [
                        'arguments' => [
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    RenderHeadSectionTagViewLayoutTags::class => [
                        'arguments' => [
                            GetServiceFromAlias::class,
                            ['literal' => ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER],
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    RenderHeadSectionTagWithRenderService::class => [
                        'factory' => RenderHeadSectionTagWithRenderServiceFactory::class,
                    ],
                    GetAvailableHeadSections::class => [
                        'factory' => GetAvailableHeadSectionsFactory::class,
                    ],
                    GetSections::class => [
                        'class' => GetSectionsHeadSectionComponent::class,
                        'arguments' => [
                            FindComponent::class
                        ],
                    ],
                    ReadViewHeadComponentConfigBc::class => [
                        'factory' => ReadViewHeadComponentConfigBcFactory::class,
                    ],
                ],
            ],
        ];
    }
}
