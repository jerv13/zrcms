<?php

namespace Zrcms\ContentCore;

use Zrcms\Content\Api\Component\BuildComponentObject;
use Zrcms\Content\Api\Component\BuildComponentObjectDefault;
use Zrcms\Content\Api\Component\PrepareComponentConfig;
use Zrcms\Content\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\ContentCore\Layout\Api\CmsResource\UpsertLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Component\PrepareComponentConfigThemeLayouts;
use Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Content\InsertLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTags;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutBasic;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCore\Theme\Model\ThemeComponentBasic;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigTheme
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
                     * ChangeLog
                     */

                    /**
                     * CmsResource
                     */
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
                    UpsertLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertLayoutCmsResource::class],
                        ],
                    ],

                    /**
                     * Component
                     */
                    PrepareComponentConfigThemeLayouts::class => [
                        'arguments' => [
                            '0-' => ReadComponentConfigJsonFile::class,
                        ],
                    ],

                    /**
                     * Content
                     */
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
                    InsertLayoutVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertLayoutVersion::class],
                        ],
                    ],

                    /**
                     * Render
                     */
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
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // @todo IS THIS USED? 'zrcms.layout.content.render-tags-getter'
                ServiceAliasLayout::ZRCMS_CONTENT_RENDERER => [
                    'mustache'
                    => RenderLayoutMustache::class,
                ],
            ],

            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                'theme' => [
                    BuildComponentObject::class => BuildComponentObjectDefault::class,
                    PrepareComponentConfig::class => PrepareComponentConfigThemeLayouts::class,
                    'component-model-interface' => ThemeComponent::class,
                    'component-model-class' => ThemeComponentBasic::class,
                ]
            ],
        ];
    }
}
