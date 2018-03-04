<?php

namespace Zrcms\CoreContainer\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertContainerCmsResource extends UpsertCmsResource
{
    /**
     * @param ContainerCmsResource|CmsResource $cmsResource
     * @param string                           $contentVersionId
     * @param string                           $modifiedByUserId
     * @param string                           $modifiedReason
     * @param string|null                      $modifiedDate
     *
     * @return ContainerCmsResource|CmsResource
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
