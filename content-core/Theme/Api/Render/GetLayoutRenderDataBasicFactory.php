<?php

namespace Zrcms\ContentCore\Theme\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetLayoutRenderDataBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetLayoutRenderDataBasic(
            $serviceContainer
        );
    }
}
