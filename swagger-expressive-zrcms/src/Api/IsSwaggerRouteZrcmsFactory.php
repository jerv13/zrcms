<?php

namespace Zrcms\SwaggerExpressiveZrcms\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsSwaggerRouteZrcmsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsSwaggerRouteZrcms
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsSwaggerRouteZrcms();
    }
}
