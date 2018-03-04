<?php

namespace Zrcms\Core\Api\CmsResource;

use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertCmsResource
{
    /**
     * Case 1 - New CmsResource - Existing ContentVersion
     * Case 2 - Existing CmsResource - Existing ContentVersion
     *
     * throws CmsResourceNotExists If received CmsResourceId but CmsResource does not exist
     * throws ContentVersionNotExists If ContentVersion does not exist
     *
     * @param CmsResource $cmsResource
     * @param string      $contentVersionId
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param string|null        $modifiedDate
     *
     * @return CmsResource
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
