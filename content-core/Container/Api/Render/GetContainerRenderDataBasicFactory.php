<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderDataBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetContainerRenderDataBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetContainerRenderDataBasic(
            $serviceContainer
        );
    }
}
