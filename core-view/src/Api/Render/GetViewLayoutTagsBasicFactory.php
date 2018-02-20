<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewLayoutTagsBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetViewLayoutTagsBasic(
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(FindComponentsBy::class)
        );
    }
}
