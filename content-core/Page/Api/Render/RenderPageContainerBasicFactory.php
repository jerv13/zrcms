<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageContainerBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderPageContainerBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderPageContainerBasic(
            $serviceContainer
        );
    }
}
