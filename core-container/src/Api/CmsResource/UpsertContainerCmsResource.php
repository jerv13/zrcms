<?php

namespace Zrcms\CoreContainer\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertContainerCmsResource extends UpsertCmsResource
{
    /**
     * @param ContainerCmsResource|CmsResource $cmsResource
     * @param string                           $modifiedByUserId
     * @param string                           $publishReason
     * @param null                             $publishDate
     *
     * @return ContainerCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
