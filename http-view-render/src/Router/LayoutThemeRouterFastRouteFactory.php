<?php

namespace Zrcms\HttpViewRender\Router;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutThemeRouterFastRouteFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return LayoutThemeRouterFastRoute
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke($serviceContainer)
    {
        $config = $serviceContainer->get('config');

        $pageLayoutConfig = $config['zrcms-http-render-layout-routes'];

        return new LayoutThemeRouterFastRoute(
            $pageLayoutConfig
        );
    }
}
