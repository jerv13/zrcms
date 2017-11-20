<?php

namespace Zrcms\ContentCore\Container\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\UpsertCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

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
