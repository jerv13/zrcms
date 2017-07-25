<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataHeadAllFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewRenderDataHeadAll
     */
    public function __invoke(
        $serviceContainer
    ) {
        // @todo Make injectable head services
        $headViewRenderDataGetters = [];

        return new GetViewRenderDataHeadAll(
            $serviceContainer,
            $headViewRenderDataGetters
        );
    }
}
