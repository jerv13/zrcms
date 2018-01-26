<?php

namespace Zrcms\HttpApi\ZrcmsConfig;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiZrcmsRoutesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiZrcmsRoutes
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiZrcmsRoutes(
            $serviceContainer->get('config')
        );
    }
}
