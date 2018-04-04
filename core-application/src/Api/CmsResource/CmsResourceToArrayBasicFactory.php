<?php

namespace Zrcms\CoreApplication\Api\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Content\ContentVersionToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return CmsResourceToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new CmsResourceToArrayBasic(
            $serviceContainer->get(ContentVersionToArray::class)
        );
    }
}
