<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedDynamic(
            $serviceContainer,
            401,
            IsDebug::invoke()
        );
    }
}
