<?php

namespace Zrcms\HttpAssetsAdminTools\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreAdminTools\Api\GetComponentCssAdminTools;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpAdminToolsComponentCssFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpAdminToolsComponentCss
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpAdminToolsComponentCss(
            $serviceContainer->get(FindComponentsBy::class),
            $serviceContainer->get(GetComponentCssAdminTools::class)
        );
    }
}
