<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderContainerBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderContainerBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderContainerBasic(
            $serviceContainer
        );
    }
}
