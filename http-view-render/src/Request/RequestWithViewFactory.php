<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\GetViewByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithView
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithView(
            $serviceContainer->get(GetViewByRequest::class),
            []
        );
    }
}
