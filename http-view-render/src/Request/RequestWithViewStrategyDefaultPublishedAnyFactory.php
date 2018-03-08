<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewStrategyDefaultPublishedAnyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithViewStrategyDefaultPublishedAny
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithViewStrategyDefaultPublishedAny();
    }
}
