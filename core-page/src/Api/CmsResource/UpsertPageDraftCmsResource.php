<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageDraftCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertPageDraftCmsResource extends UpsertCmsResource
{
    /**
     * @param PageDraftCmsResource|CmsResource $cmsResource
     * @param string                           $contentVersionId
     * @param string                           $modifiedByUserId
     * @param string                           $modifiedReason
     * @param string|null                      $modifiedDate
     *
     * @return PageDraftCmsResource|CmsResource
     * @throws CmsResourceNotExists
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource;
}
