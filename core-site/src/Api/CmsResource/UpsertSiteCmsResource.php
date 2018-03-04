<?php

namespace Zrcms\CoreSite\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertSiteCmsResource extends UpsertCmsResource
{
    /**
     * @param SiteCmsResource|CmsResource $cmsResource
     * @param string                      $contentVersionId
     * @param string                      $modifiedByUserId
     * @param string                      $modifiedReason
     * @param string|null                 $modifiedDate
     *
     * @return SiteCmsResource|CmsResource
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
