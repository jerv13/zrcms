<?php

namespace Zrcms\CoreSite\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertSiteCmsResource extends UpsertCmsResource
{
    /**
     * @param SiteCmsResource|CmsResource $cmsResource
     * @param string                      $modifiedByUserId
     * @param string                      $publishReason
     * @param null                        $publishDate
     *
     * @return SiteCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
