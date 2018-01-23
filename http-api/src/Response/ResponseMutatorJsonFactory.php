<?php

namespace Zrcms\HttpApi\Response;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorJsonFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ResponseMutatorJson
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ResponseMutatorJson(
            ['application/json', 'json'],
            [200, 201, 204, 301, 302],
            IsDebug::invoke()
        );
    }
}
