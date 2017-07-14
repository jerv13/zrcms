<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertCmsResource
{
    /**
     * @param CmsResource $cmsResource
     * @param array       $options
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): CmsResource;
}
