<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishContentVersion
{
    /**
     * @param CmsResource $cmsResource
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource
    ): CmsResource;
}
