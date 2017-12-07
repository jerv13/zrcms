<?php

namespace Zrcms\CoreRedirect\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertRedirectCmsResource extends UpsertCmsResource
{
    /**
     * @param RedirectCmsResource|CmsResource $cmsResource
     * @param string                          $modifiedByUserId
     * @param string                          $publishReason
     * @param null                            $publishDate
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
