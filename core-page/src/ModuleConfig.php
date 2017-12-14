<?php

namespace Zrcms\CorePage;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
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
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
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
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertPageVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
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
