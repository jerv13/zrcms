<?php

namespace Zrcms\CoreContainer\Api\CmsResource;

use Zrcms\CoreContainer\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourcesBySiteNames
{
    /**
     * @param string    $siteCmsResourceId
     * @param array     $containerCmsResourceNames
     * @param bool|null $published
     * @param array     $options
     *
     * @return ContainerCmsResource[]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourceNames,
        $published = true,
        array $options = []
    ): array;
}
