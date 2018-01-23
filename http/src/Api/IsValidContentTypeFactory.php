<?php

namespace Zrcms\Http\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsValidContentTypeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsValidContentType
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsValidContentType();
    }
}
