<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\HttpApi\GetDynamicApiValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateFieldsDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiValidateFieldsDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiValidateFieldsDynamic(
            $serviceContainer,
            $serviceContainer->get(GetRouteOptions::class),
            $serviceContainer->get(GetDynamicApiValue::class),
            400,
            IsDebug::invoke()
        );
    }
}
