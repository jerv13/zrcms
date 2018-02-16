<?php

namespace Zrcms\HttpAssetsAdminTools\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreAdminTools\Api\GetComponentJsAdminTools;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpAdminToolsComponentJsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpAdminToolsComponentJs
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpAdminToolsComponentJs(
            $serviceContainer->get(FindComponentsBy::class),
            $serviceContainer->get(GetComponentJsAdminTools::class)
        );
    }
}
