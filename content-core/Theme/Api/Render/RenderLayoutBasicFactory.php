<?php

namespace Zrcms\ContentCore\Theme\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLayoutBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderLayoutBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderLayoutBasic(
            $serviceContainer
        );
    }
}
