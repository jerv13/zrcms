<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Layout\Api\CmsResource\UpsertLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfig;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigByStrategy;
use Zrcms\ContentCore\Theme\Api\Component\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentConfig;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentConfigByStrategy;
use Zrcms\ContentCore\Theme\Api\Component\ReadThemeComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTags;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderTagsNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutBasic;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Content\InsertLayoutVersion;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ContentCore\Theme\Model\ServiceAliasTheme;
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
                    UpsertLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertLayoutCmsResource::class],
                        ],
                    ],
                    ReadLayoutComponentConfig::class => [
                        'class' => ReadLayoutComponentConfigByStrategy::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadLayoutComponentConfigJsonFile::class => [
                        'class' => ReadLayoutComponentConfigJsonFile::class,
                    ],

                    ReadThemeComponentConfig::class => [
                        'class' => ReadThemeComponentConfigByStrategy::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadThemeComponentConfigJsonFile::class => [
                        'class' => ReadThemeComponentConfigJsonFile::class,
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
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.theme.component.config-reader'
                ServiceAliasTheme::NAMESPACE_COMPONENT_CONFIG_READER => [
                    'json'
                    => ReadThemeComponentConfigJsonFile::class,
                ],
                // @todo IS THIS USED? 'zrcms.layout.content.render-tags-getter'
                ServiceAliasLayout::NAMESPACE_CONTENT_RENDERER => [
                    'mustache'
                    => RenderLayoutMustache::class,
                ],
            ],
        ];
    }
}
