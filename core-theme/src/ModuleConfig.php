<?php

namespace Zrcms\CoreTheme;

use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\SearchComponentConfigs;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
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
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpsertLayoutCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
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
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertLayoutVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
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
        ];
    }
}
