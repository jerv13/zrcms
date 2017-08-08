<?php

namespace Zrcms\ViewLayoutTagsHead;

use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHead;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadAll;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadLink;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadMeta;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadScript;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadTitle;

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
                    GetViewRenderTagsHead::class => [
                        'class' => GetViewRenderTagsHeadAll::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewRenderTagsHeadAll::class => [
                        'class' => GetViewRenderTagsHeadAll::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewRenderTagsHeadLink::class => [],
                    GetViewRenderTagsHeadMeta::class => [],
                    GetViewRenderTagsHeadScript::class => [],
                    GetViewRenderTagsHeadTitle::class => [],
                ],
            ],
            'zrcms' => [
                'view-layout-tags' => [
                    GetViewRenderTagsHeadAll::RENDER_TAG_ALL => __DIR__ . '/../config/head-all',
                    GetViewRenderTagsHeadLink::RENDER_TAG_LINK => __DIR__ . '/../config/head-link',
                    GetViewRenderTagsHeadMeta::RENDER_TAG_META => __DIR__ . '/../config/head-meta',
                    GetViewRenderTagsHeadScript::RENDER_TAG_SCRIPT => __DIR__ . '/../config/head-script',
                    GetViewRenderTagsHeadTitle::RENDER_TAG_TITLE => __DIR__ . '/../config/head-title',
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    GetViewRenderTagsHeadAll::SERVICE_ALIAS => GetViewRenderTagsHeadAll::class,
                    GetViewRenderTagsHeadLink::SERVICE_ALIAS => GetViewRenderTagsHeadLink::class,
                    GetViewRenderTagsHeadMeta::SERVICE_ALIAS => GetViewRenderTagsHeadMeta::class,
                    GetViewRenderTagsHeadScript::SERVICE_ALIAS => GetViewRenderTagsHeadScript::class,
                    GetViewRenderTagsHeadTitle::SERVICE_ALIAS => GetViewRenderTagsHeadTitle::class,
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
                'sections' => [
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
                            '_content' => '{string}',
                            '{attribute-name}' => '{string}',
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
