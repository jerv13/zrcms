<?php

namespace Zrcms\ViewHead;

use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\PropertiesViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHead;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadAll;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadLink;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadMeta;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadScript;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadTitle;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTag;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTagBasic;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTagBcFactory;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTagBasic;
use Zrcms\ViewHtmlTags\Api\Render\RenderTags;
use Zrcms\ViewHtmlTags\Api\Render\RenderTagsBasic;
use Zrcms\ViewHead\Api\Repository\ReadViewHeadComponentConfigBc;
use Zrcms\ViewHead\Api\Repository\ReadViewHeadComponentConfigBcFactory;

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
                    GetViewLayoutTagsHead::class => [
                        'class' => GetViewLayoutTagsHeadAll::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadAll::class => [
                        'class' => GetViewLayoutTagsHeadAll::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadLink::class => [
                        'arguments' => [
                            '0-' => FindViewLayoutTagsComponent::class,
                            '1-' => RenderHeadSectionsTag::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadMeta::class => [
                        'arguments' => [
                            '0-' => FindViewLayoutTagsComponent::class,
                            '1-' => RenderTags::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadScript::class => [
                        'arguments' => [
                            '0-' => FindViewLayoutTagsComponent::class,
                            '1-' => RenderHeadSectionsTag::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadTitle::class => [],
                    RenderHeadSectionsTag::class => [
                        'class' => RenderHeadSectionsTagBasic::class,
                        'arguments' => [
                            '0-' => RenderTag::class,
                        ],
                    ],
                    RenderTag::class => [
                        'class' => RenderTagBasic::class,
                    ],
                    RenderTags::class => [
                        'class' => RenderTagsBasic::class,
                        'arguments' => [
                            '0-' => RenderTag::class,
                        ],
                    ],
                    ReadViewHeadComponentConfigBc::class => [
                        'factory' => ReadViewHeadComponentConfigBcFactory::class,
                    ],
                ],
            ],
            'zrcms-components' => [
                'view-layout-tags' => [
                    GetViewLayoutTagsHeadAll::RENDER_TAG_ALL
                    => __DIR__ . '/../config/head-all',

                    GetViewLayoutTagsHeadMeta::RENDER_TAG_META => [

                        ComponentRegistryFields::CONFIG_LOCATION
                        => GetViewLayoutTagsHeadMeta::RENDER_TAG_META,

                        ComponentRegistryFields::COMPONENT_CONFIG_READER
                        => ReadViewHeadComponentConfigBc::SERVICE_ALIAS,

                        ComponentRegistryFields::NAME
                        => GetViewLayoutTagsHeadMeta::RENDER_TAG_META,

                        PropertiesViewLayoutTagsComponent::RENDER_TAGS_GETTER
                        => GetViewLayoutTagsHeadMeta::SERVICE_ALIAS,

                        'tags' => [],
                    ],

                    // GetViewLayoutTagsHeadLink::RENDER_TAG_LINK
                    'head-link' => [

                        ComponentRegistryFields::CONFIG_LOCATION
                        => GetViewLayoutTagsHeadLink::RENDER_TAG_LINK,

                        ComponentRegistryFields::COMPONENT_CONFIG_READER
                        => ReadViewHeadComponentConfigBc::SERVICE_ALIAS,

                        ComponentRegistryFields::NAME
                        => GetViewLayoutTagsHeadLink::RENDER_TAG_LINK,

                        PropertiesViewLayoutTagsComponent::RENDER_TAGS_GETTER
                        => GetViewLayoutTagsHeadLink::SERVICE_ALIAS,

                        'tag' => 'link',
                        'sections' => [
                            'pre-config' => [
                                /*
                                'EXAMPLE' => [
                                    '_content' => 'EXAMPLE',
                                    'href' => '/example/example.css',
                                    'media' => "screen,print",
                                    'rel' => "stylesheet",
                                    'type' => "text/css"
                                ],
                                */
                            ],
                            'config' => [],
                            'post-config' => [],
                            'pre-libraries' => [],
                            'libraries' => [],
                            'post-libraries' => [],
                            'pre-core' => [],
                            'core' => [],
                            'post-core' => [],
                            'pre-modules' => [],
                            'modules' => [],
                            'post-modules' => [],
                        ],
                    ],

                    GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT => [
                        ComponentRegistryFields::CONFIG_LOCATION
                        => GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT,

                        ComponentRegistryFields::COMPONENT_CONFIG_READER
                        => ReadViewHeadComponentConfigBc::SERVICE_ALIAS,

                        ComponentRegistryFields::NAME
                        => GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT,

                        PropertiesViewLayoutTagsComponent::RENDER_TAGS_GETTER
                        => GetViewLayoutTagsHeadScript::SERVICE_ALIAS,

                        'tag' => 'script',
                        'sections' => [
                            'pre-config' => [],
                            'config' => [],
                            'post-config' => [],
                            'pre-libraries' => [],
                            'libraries' => [],
                            'post-libraries' => [],
                            'pre-core' => [],
                            'core' => [],
                            'post-core' => [],
                            'pre-modules' => [],
                            'modules' => [],
                            'post-modules' => [],
                        ],
                    ],
                    GetViewLayoutTagsHeadTitle::RENDER_TAG_TITLE => __DIR__ . '/../config/head-title',
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutTagsHeadAll::SERVICE_ALIAS => GetViewLayoutTagsHeadAll::class,
                    GetViewLayoutTagsHeadLink::SERVICE_ALIAS => GetViewLayoutTagsHeadLink::class,
                    GetViewLayoutTagsHeadMeta::SERVICE_ALIAS => GetViewLayoutTagsHeadMeta::class,
                    GetViewLayoutTagsHeadScript::SERVICE_ALIAS => GetViewLayoutTagsHeadScript::class,
                    GetViewLayoutTagsHeadTitle::SERVICE_ALIAS => GetViewLayoutTagsHeadTitle::class,
                ],

                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_CONFIG_READER => [
                    ReadViewHeadComponentConfigBc::SERVICE_ALIAS => ReadViewHeadComponentConfigBc::class,
                ],
            ],

            /**
             * This determines the order of the head sections, thus, loading order of scripts and css
             */
            'zrcms-head-available-sections' => [
                'pre-config',
                'config',
                'post-config',
                'pre-libraries',
                'libraries',
                'post-libraries',
                'pre-core',
                'core',
                'post-core',
                'pre-modules',
                'modules',
                'post-modules',
            ],
        ];
    }
}
