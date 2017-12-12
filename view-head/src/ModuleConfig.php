<?php

namespace Zrcms\ViewHead;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\CoreView\Fields\FieldsViewLayoutTagsComponent;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ViewHead\Api\Component\ReadViewHeadComponentConfigBc;
use Zrcms\ViewHead\Api\Component\ReadViewHeadComponentConfigBcFactory;
use Zrcms\ViewHead\Api\GetHeadSections;
use Zrcms\ViewHead\Api\GetHeadSectionsFactory;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHead;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadAll;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadLink;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadMeta;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadScript;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadTitle;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTag;
use Zrcms\ViewHead\Api\Render\RenderHeadSectionsTagBasic;
use Zrcms\ViewHead\Model\HeadSectionComponent;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTags;

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
                            FindComponent::class,
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
                            FindComponent::class,
                            RenderHeadSectionsTag::class,
                        ],
                    ],
                    GetViewLayoutTagsHeadTitle::class => [],
                    RenderHeadSectionsTag::class => [
                        'class' => RenderHeadSectionsTagBasic::class,
                        'arguments' => [
                            RenderTag::class,
                            GetHeadSections::class,
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetHeadSections::class => [
                        'factory' => GetHeadSectionsFactory::class,
                    ],
                    ReadViewHeadComponentConfigBc::class => [
                        'factory' => ReadViewHeadComponentConfigBcFactory::class,
                    ],
                ],
            ],
            'zrcms-components' => [
                'view-layout-tag.head-all'
                => 'json:' . __DIR__ . '/../config/head-all/view-layout-tags.json',

                'view-layout-tag.head-link'
                => 'view-head-bc:zrcms-view-head.head-link',

                'view-layout-tag.head-meta'
                => 'view-head-bc:zrcms-view-head.head-meta',

                'view-layout-tag.head-script'
                => 'view-head-bc:zrcms-view-head.head-script',

                'view-layout-tag.head-title'
                => 'json:' . __DIR__ . '/../config/head-title/view-layout-tags.json',
            ],

            'zrcms-view-head.head-link' => [
                FieldsComponentConfig::TYPE => 'view-layout-tag',
                // GetViewLayoutTagsHeadLink::RENDER_TAG_LINK
                FieldsComponentConfig::NAME => 'head-link',

                FieldsComponentConfig::MODULE_DIRECTORY
                => __DIR__ . '/..',

                FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER
                => GetViewLayoutTagsHeadLink::SERVICE_ALIAS,

                FieldsViewLayoutTagsComponent::COMPONENT_CLASS
                => HeadSectionComponent::class,

                'tag' => 'link',
                'sections' => [
                    'pre-config' => [
                        /* EXAMPLE
                        // Basic
                        '{name}' => [
                            '__content' => '.example {};',
                            'href' => '/example/example.css',
                            'media' => "screen,print",
                            'rel' => "stylesheet",
                            'type' => "text/css"
                        ],
                        // Embedded ViewLayoutTagsGetter
                        '{name}' => [
                            '__view-layout-tags-getter' => '{view-layout-tag-getter-service-alias}',
                        ],
                        // Literal
                        '{name}' => [
                            '__literal' => '{view-layout-tag-getter-service-alias}',
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
            'zrcms-view-head.head-meta' => [
                FieldsComponentConfig::TYPE => 'view-layout-tag',
                /* GetViewLayoutTagsHeadMeta::RENDER_TAG_META */
                FieldsComponentConfig::NAME => 'head-meta',

                FieldsComponentConfig::MODULE_DIRECTORY
                => __DIR__ . '/..',

                FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER
                => GetViewLayoutTagsHeadMeta::SERVICE_ALIAS,

                'tags' => [
                ],
            ],
            'zrcms-view-head.head-script' => [
                FieldsComponentConfig::TYPE => 'view-layout-tag',
                /* GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT */
                FieldsComponentConfig::NAME => 'head-script',

                FieldsComponentConfig::MODULE_DIRECTORY
                => __DIR__ . '/..',

                FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER
                => GetViewLayoutTagsHeadScript::SERVICE_ALIAS,

                FieldsViewLayoutTagsComponent::COMPONENT_CLASS
                => HeadSectionComponent::class,

                'tag' => 'script',
                'sections' => [
                    'pre-config' => [
                        /* EXAMPLE
                        // Basic
                        '{name}' => [
                            '__content' => 'var example = null;',
                            'src' => '/example/example.js',
                            'type' => "text/javascript"
                        ],
                        // Embedded ViewLayoutTagsGetter
                        '{name}' => [
                            '__view-layout-tags-getter' => '{view-layout-tag-getter-service-alias}',
                        ],
                        // Literal
                        '{name}' => [
                            '__literal' => '{view-layout-tag-getter-service-alias}',
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

            'zrcms-service-alias' => [
                ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutTagsHeadAll::SERVICE_ALIAS => GetViewLayoutTagsHeadAll::class,
                    GetViewLayoutTagsHeadLink::SERVICE_ALIAS => GetViewLayoutTagsHeadLink::class,
                    GetViewLayoutTagsHeadMeta::SERVICE_ALIAS => GetViewLayoutTagsHeadMeta::class,
                    GetViewLayoutTagsHeadScript::SERVICE_ALIAS => GetViewLayoutTagsHeadScript::class,
                    GetViewLayoutTagsHeadTitle::SERVICE_ALIAS => GetViewLayoutTagsHeadTitle::class,
                ],

                ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER => [
                    ReadViewHeadComponentConfigBc::SERVICE_ALIAS => ReadViewHeadComponentConfigBc::class,
                ],
            ],

            /**
             * This determines the order of the head sections, thus, loading order of scripts and css
             */
            'zrcms-head-available-sections' => [
                'pre-config' => [
                    'name' => 'pre-config',
                    'priority' => 1200
                ],
                'config' => [
                    'name' => 'config',
                    'priority' => 1100
                ],
                'post-config' => [
                    'name' => 'post-config',
                    'priority' => 1000
                ],
                'pre-libraries' => [
                    'name' => 'pre-libraries',
                    'priority' => 900
                ],
                'libraries' => [
                    'name' => 'libraries',
                    'priority' => 800
                ],
                'post-libraries' => [
                    'name' => 'post-libraries',
                    'priority' => 700
                ],
                'pre-core' => [
                    'name' => 'pre-core',
                    'priority' => 600
                ],
                'core' => [
                    'name' => 'core',
                    'priority' => 500
                ],
                'post-core' => [
                    'name' => 'post-core',
                    'priority' => 400
                ],
                'pre-modules' => [
                    'name' => 'pre-modules',
                    'priority' => 300
                ],
                'modules' => [
                    'name' => 'modules',
                    'priority' => 200
                ],
                'post-modules' => [
                    'name' => 'post-modules',
                    'priority' => 100
                ],
            ],
        ];
    }
}
