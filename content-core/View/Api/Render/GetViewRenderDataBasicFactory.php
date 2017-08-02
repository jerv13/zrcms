<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewRenderDataBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetViewRenderDataBasic(
            $serviceContainer,
            $serviceContainer->get(FindViewRenderDataGetterComponentsBy::class)
        );
    }
}
