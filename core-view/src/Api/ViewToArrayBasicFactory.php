<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ViewToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ViewToArrayBasic(
            $serviceContainer->get(CmsResourceToArray::class)
        );
    }
}
