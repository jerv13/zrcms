<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderDataBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetPageContainerRenderDataBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetPageContainerRenderDataBasic(
            $serviceContainer
        );
    }
}
