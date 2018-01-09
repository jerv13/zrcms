<?php

namespace Zrcms\Core\Api\CmsResource;

use Zrcms\Core\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourceToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

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
