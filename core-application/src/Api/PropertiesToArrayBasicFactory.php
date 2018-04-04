<?php

namespace Zrcms\CoreApplication\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return PropertiesToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new PropertiesToArrayBasic();
    }
}
