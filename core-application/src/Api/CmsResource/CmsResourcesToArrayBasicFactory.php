<?php

namespace Zrcms\CoreApplication\Api\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourcesToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return CmsResourcesToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new CmsResourcesToArrayBasic(
            $serviceContainer->get(CmsResourceToArray::class)
        );
    }
}
