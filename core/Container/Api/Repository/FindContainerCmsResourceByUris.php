<?php

namespace Zrcms\Core\Container\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourceByUris
{
    /**
     * @param array $uris
     * @param array $options
     *
     * @return array [ContainerCmsResource]
     */
    public function __invoke(array $uris, array $options = []);
}
