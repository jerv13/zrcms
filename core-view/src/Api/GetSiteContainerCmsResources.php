<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreContainer\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetSiteContainerCmsResources
{
    const OPTION_LAYOUT_VERSION = 'layout-version';
    /**
     * @param string $siteCmsResourceId
     * @param array  $options
     *
     * @return ContainerCmsResource[]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $options = []
    ): array;
}
