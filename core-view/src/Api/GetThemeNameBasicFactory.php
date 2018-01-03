<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetThemeNameBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetThemeNameBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetThemeNameBasic(
            $serviceContainer->get(FindComponent::class)
        );
    }
}
