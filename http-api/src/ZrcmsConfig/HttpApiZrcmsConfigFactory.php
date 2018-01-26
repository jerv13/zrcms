<?php

namespace Zrcms\HttpApi\ZrcmsConfig;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiZrcmsConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiZrcmsConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiZrcmsConfig(
            $serviceContainer->get('config')
        );
    }
}
