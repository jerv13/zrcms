<?php

namespace Zrcms\HttpApiSwagger\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiSwaggerFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiSwagger
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        return new HttpApiSwagger(
            $appConfig,
            $appConfig['zrcms-http-api-swagger'],
            IsDebug::invoke()
        );
    }
}
