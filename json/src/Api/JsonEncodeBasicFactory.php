<?php

namespace Zrcms\Json\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class JsonEncodeBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return JsonEncodeBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new JsonEncodeBasic();
    }
}
