<?php

namespace Zrcms\Json\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class JsonDecodeBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return JsonDecodeBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new JsonDecodeBasic();
    }
}
