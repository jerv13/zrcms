<?php

namespace Zrcms\CorePage;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesPublished;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesPublished;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResourceHistory\FindPageCmsResourceHistory;
use Zrcms\CorePage\Api\CmsResourceHistory\FindPageCmsResourceHistoryBy;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Api\Content\FindPageVersionsBy;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsBasic;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsContainers;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsHtml;
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
                     * CmsResource
                     */
                    CreatePageCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
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
                    FindPageCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    FindPageTemplateCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageTemplateCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    UpsertPageCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    FindPageCmsResourceHistory::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageCmsResourceHistoryBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * ContentVersion
                     */
                    FindPageVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindPageVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    InsertPageVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    /**
                     * Render
                     */
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
                ],
            ],
        ];
    }
}
