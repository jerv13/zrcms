<?php

namespace Zrcms\Content\Api\CmsResource;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceToArray
{
    /**
     * @param CmsResource $cmsResource
     * @param array       $options
     *
     * @return array
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): array;
}
