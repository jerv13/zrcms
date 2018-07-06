<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class WrapRenderedBlockVersionLegacyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return WrapRenderedBlockVersionLegacy
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new WrapRenderedBlockVersionLegacy(
            $serviceContainer->get(FindComponent::class)
        );
    }
}
