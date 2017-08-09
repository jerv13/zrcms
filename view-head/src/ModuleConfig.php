<?php

namespace Zrcms\ViewLayoutTagsHead;

use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Api\Repository\ReadViewLayoutTagsComponentConfigApplicationConfig;
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
use Zrcms\ViewHead\Api\Render\RenderTag;
use Zrcms\ViewHead\Api\Render\RenderTagBasic;

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
                    GetViewLayoutTagsHeadMeta::class => [],
                    GetViewLayoutTagsHeadScript::class => [],
                    GetViewLayoutTagsHeadTitle::class => [],
                    RenderHeadSectionsTag::class => [
                        'class' => RenderHeadSectionsTagBasic::class,
                        'arguments' => [
                            '0-' => RenderTag::class,
                            // @todo THIS IS WRONG =======================================================
                            '1-' => [
                                'literal' => [
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
                                ]
                            ],
                        ],
                    ],
                    RenderTag::class => [
                        'class' => RenderTagBasic::class
                    ],
                ],
            ],
            'zrcms-components' => [
                'view-layout-tags' => [
                    GetViewLayoutTagsHeadAll::RENDER_TAG_ALL => __DIR__ . '/../config/head-all',
                    GetViewLayoutTagsHeadLink::RENDER_TAG_LINK => [

                        ComponentRegistryFields::CONFIG_LOCATION
                        => GetViewLayoutTagsHeadLink::RENDER_TAG_LINK,

                        ComponentRegistryFields::COMPONENT_CONFIG_READER
                        => ReadViewLayoutTagsComponentConfigApplicationConfig::SERVICE_ALIAS,

                        ComponentRegistryFields::NAME => GetViewLayoutTagsHeadLink::RENDER_TAG_LINK,

                        'tag' => 'link',
                        'sections' => [
                            'pre-config' => [
                                'TEST' => [
                                    '_content' => 'TESTTEST',
                                    'href' => '/test/test.css',
                                    'media' => "screen,print",
                                    'rel' => "stylesheet",
                                    'type' => "text/css"
                                ],
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
                    GetViewLayoutTagsHeadMeta::RENDER_TAG_META => __DIR__ . '/../config/head-meta',
                    GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT => __DIR__ . '/../config/head-script',
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
            ],

            'zrcms-head-definitions' => [
                /**
                 * Set the script key to use
                 * Useful for setting up prebuilt (minimized and combined) files
                 */
                'defaultScriptKey' => 'scripts',

                /**
                 * Set the stylesheet key to use
                 * Useful for setting up prebuilt (minimized and combined) files
                 */
                'defaultStylesheetKey' => 'stylesheets',

                /**
                 * This determines the order of the head sections, thus, loading order of scripts and css
                 */
                'available-sections' => [
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
            ],

            /**
             * Scripts to be required always on every page
             */
            'zrcms-head' => [

                '{tag}' => [
                    '{section}' => [
                        '{name}' => [
                            '_content' => '{value}',
                            '{attribute-name}' => '{value}',
                        ]
                    ]
                ],

                /**
                 * Meta tags that will always be loaded
                 * Example
                 * 'keyValue' => [
                 *  'content' => 'value',
                 *  'modifiers' => [],
                 * ],
                 */
                'meta' => [
                    // @todo this is for the application to do
                    'X-UA-Compatible' => [
                        'content' => 'IE=edge',
                    ],
                    // @todo this is for the application to do
                    'viewport' => [
                        'content' => 'width=device-width, initial-scale=1',
                    ],
                ],

                /**
                 * Script files that will always be loaded
                 * Example:
                 * 'section' => [
                 *  '/script/url' => [
                 *   'type' => 'text/javascript',
                 *   'attrs' => []
                 *  ],
                 * ],
                 */
                'scripts' => [
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

                /**
                 * Stylesheet files that will always be loaded
                 * Example:
                 * 'section' => [
                 *  '/stylesheet/url' => [
                 *   'media' => 'screen',
                 *   'conditionalStylesheet' => '',
                 *   'extras' => []
                 *  ],
                 * ],
                 */
                'stylesheets' => [
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
            ]
        ];
    }
}
