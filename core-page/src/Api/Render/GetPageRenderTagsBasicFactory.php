<?php

namespace Zrcms\CorePage\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageRenderTagsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetPageRenderTagsBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetPageRenderTagsBasic(
            $serviceContainer->get(GetServiceFromAlias::class)
        );
    }
}
