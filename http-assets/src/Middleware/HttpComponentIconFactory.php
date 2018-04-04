<?php

namespace Zrcms\HttpAssets\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\GetModuleDirectoryFilePath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpComponentIconFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpComponentIcon
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpComponentIcon(
            $serviceContainer->get(FindComponent::class),
            $serviceContainer->get(GetModuleDirectoryFilePath::class)
        );
    }
}
