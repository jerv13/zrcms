<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResource;

use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerCmsResourcesBySiteNames
{
    /**
     * @param string    $siteCmsResourceId
     * @param array     $containerCmsResourceNames
     * @param bool|null $published
     * @param array     $options
     *
     * @return SiteContainerCmsResource[]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourceNames,
        $published = true,
        array $options = []
    ): array;
}
