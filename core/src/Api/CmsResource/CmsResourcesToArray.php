<?php

namespace Zrcms\Core\Api\CmsResource;

use Zrcms\Core\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResourcesToArray
{
    const OPTION_CMS_RESOURCE_OPTIONS = 'cms-resource-options';
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @param CmsResource[] $cmsResources
     * @param array         $options
     *
     * @return array
     */
    public function __invoke(
        array $cmsResources,
        array $options = []
    ): array;
}
