<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\InputValidationZrcms\Api\ValidateId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateIdAttributeDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiValidateIdAttributeDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiValidateIdAttributeDynamic(
            $serviceContainer,
            $serviceContainer->get(GetRouteOptions::class),
            $serviceContainer->get(GetDynamicApiValue::class),
            $serviceContainer->get(ValidateId::class),
            400,
            IsDebug::invoke()
        );
    }
}
