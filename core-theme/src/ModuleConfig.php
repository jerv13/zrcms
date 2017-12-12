<?php

namespace Zrcms\CoreTheme;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\SearchComponentConfigs;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Exception\IMPLEMENTATION_REQUIRED;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourcesBy;
use Zrcms\CoreTheme\Api\CmsResource\UpsertLayoutCmsResource;
use Zrcms\CoreTheme\Api\Component\BuildComponentObjectThemeLayout;
use Zrcms\CoreTheme\Api\Component\BuildComponentObjectThemeLayouts;
use Zrcms\CoreTheme\Api\Content\FindLayoutVersion;
use Zrcms\CoreTheme\Api\Content\FindLayoutVersionsBy;
use Zrcms\CoreTheme\Api\Content\InsertLayoutVersion;
use Zrcms\CoreTheme\Api\Render\GetLayoutRenderTags;
use Zrcms\CoreTheme\Api\Render\GetLayoutRenderTagsBasic;
use Zrcms\CoreTheme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\CoreTheme\Api\Render\RenderLayout;
use Zrcms\CoreTheme\Api\Render\RenderLayoutBasic;
use Zrcms\CoreTheme\Api\Render\RenderLayoutMustache;
use Zrcms\CoreTheme\Model\LayoutComponent;
use Zrcms\CoreTheme\Model\LayoutComponentBasic;
use Zrcms\CoreTheme\Model\ServiceAliasLayout;
use Zrcms\CoreTheme\Model\ThemeComponent;
use Zrcms\CoreTheme\Model\ThemeComponentBasic;
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
                     * ChangeLog
                     */

                    /**
                     * CmsResource
                     */
                    FindLayoutCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    UpsertLayoutCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * Component
                     */
                    BuildComponentObjectThemeLayout::class => [],
                    BuildComponentObjectThemeLayouts::class => [
                        'arguments' => [
                            ReadComponentConfigs::class,
                            SearchComponentConfigs::class,
                            BuildComponentObjectThemeLayout::class,
                            GetTypeValue::class,
                            ['literal' => ThemeComponentBasic::class]
                        ],
                    ],

                    /**
                     * Content
                     */
                    FindLayoutVersion::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    InsertLayoutVersion::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * Render
                     */
                    GetLayoutRenderTags::class => [
                        'class' => GetLayoutRenderTagsBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetLayoutRenderTagsNoop::class => [],
                    RenderLayout::class => [
                        'class' => RenderLayoutBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
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
                    BuildComponentObject::class => BuildComponentObjectThemeLayouts::class,
                    'component-model-interface' => ThemeComponent::class,
                    'component-model-class' => ThemeComponentBasic::class,
                ],
                'theme-layout' => [
                    BuildComponentObject::class => BuildComponentObjectThemeLayout::class,
                    'component-model-interface' => LayoutComponent::class,
                    'component-model-class' => LayoutComponentBasic::class,
                ]
            ],
        ];
    }
}
