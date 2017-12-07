<?php

namespace Zrcms\Core\Api\CmsResource;

use Zrcms\Core\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertCmsResource
{
    /**
     * @param CmsResource $cmsResource
     * @param string      $modifiedByUserId
     * @param string      $publishReason
     * @param string|null $publishDate
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
