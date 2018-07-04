<?php

namespace Zrcms\CorePage;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesPublished;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesPublished;
use Zrcms\CorePage\Api\CmsResource\UpdatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpdatePageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpdatePageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResourceHistory\FindPageCmsResourceHistory;
use Zrcms\CorePage\Api\CmsResourceHistory\FindPageCmsResourceHistoryBy;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Api\Content\FindPageVersionsBy;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsBasicFactory;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsContainers;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsContainersFactory;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsHtml;

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

                    UpdatePageCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpdatePageTemplateCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpdatePageDraftCmsResource::class => [
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
                        'factory' => GetPageRenderTagsBasicFactory::class,
                    ],
                    GetPageRenderTagsContainers::class => [
                        'factory' => GetPageRenderTagsContainersFactory::class,
                    ],
                    GetPageRenderTagsHtml::class => [],
                ],
            ],
        ];
    }
}
