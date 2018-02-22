<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithIdentifierFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithIdentifier
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithIdentifier();
    }
}
