<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

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
            400,
            IsDebug::invoke()
        );
    }
}
