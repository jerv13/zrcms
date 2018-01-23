<?php

namespace Zrcms\Http\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsValidAcceptTypeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsValidAcceptType
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsValidAcceptType();
    }
}
