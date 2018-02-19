<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithOriginalUriFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithOriginalUri
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithOriginalUri();
    }
}
