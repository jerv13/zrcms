<?php

namespace Zrcms\CorePage;

use Zrcms\Core\Exception\IMPLEMENTATION_REQUIRED;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Api\Content\FindPageVersionsBy;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsBasic;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsContainers;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsHtml;
use Zrcms\CorePage\Model\ServiceAliasPage;
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
                    UpsertPageCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    GetPageRenderTags::class => [
                        'class' => GetPageRenderTagsBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                        ],
                    ],
                    GetPageRenderTagsHtml::class => [],
                    GetPageRenderTagsContainers::class => [
                        'arguments' => [
                            GetContainerRenderTags::class,
                            RenderContainer::class,
                        ],
                    ],
                    FindPageCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindPageVersion::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindPageVersionsBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    InsertPageVersion::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.page.content.render-tags-getter'
                ServiceAliasPage::ZRCMS_CONTENT_RENDER_TAGS_GETTER => [
                    'containers'
                    => GetPageRenderTagsContainers::class,

                    'html'
                    => GetPageRenderTagsHtml::class,
                ],
            ],
        ];
    }
}
