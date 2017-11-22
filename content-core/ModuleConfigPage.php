<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTags;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTagsBasic;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTagsContainers;
use Zrcms\ContentCore\Page\Api\Render\GetPageRenderTagsHtml;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Content\FindPageVersion;
use Zrcms\ContentCore\Page\Api\Content\FindPageVersionsBy;
use Zrcms\ContentCore\Page\Api\Content\InsertPageVersion;
use Zrcms\ContentCore\Page\Model\ServiceAliasPage;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigPage
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    UpsertPageCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertPageCmsResource::class],
                        ],
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertPageTemplateCmsResource::class],
                        ],
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertPageDraftCmsResource::class],
                        ],
                    ],
                    GetPageRenderTags::class => [
                        'class' => GetPageRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetPageRenderTagsHtml::class => [],
                    GetPageRenderTagsContainers::class => [
                        'arguments' => [
                            '0-' => GetContainerRenderTags::class,
                            '1-' => RenderContainer::class,
                        ],
                    ],
                    FindPageCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageCmsResource::class],
                        ],
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageCmsResourceBySitePath::class],
                        ],
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageCmsResourcesBy::class],
                        ],
                    ],
                    FindPageVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageVersion::class],
                        ],
                    ],
                    FindPageVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageVersionsBy::class],
                        ],
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageTemplateCmsResourceBySitePath::class],
                        ],
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageTemplateCmsResourcesBy::class],
                        ],
                    ],
                    InsertPageVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertPageVersion::class],
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.page.content.render-tags-getter'
                ServiceAliasPage::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    'containers'
                    => GetPageRenderTagsContainers::class,

                    'html'
                    => GetPageRenderTagsHtml::class,
                ],
            ],
        ];
    }
}
