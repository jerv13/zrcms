<?php

namespace Zrcms\CoreRedirect\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertRedirectCmsResource extends UpsertCmsResource
{
    /**
     * @param RedirectCmsResource|CmsResource $cmsResource
     * @param string                          $contentVersionId
     * @param string                          $modifiedByUserId
     * @param string                          $modifiedReason
     * @param string|null                     $modifiedDate
     *
     * @return RedirectCmsResource|CmsResource
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
