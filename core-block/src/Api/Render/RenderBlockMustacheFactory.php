<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Container\ContainerInterface;
use Reliv\Mustache\Resolver\FileResolver;
use Zrcms\Core\Api\Component\FindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockMustacheFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderBlockMustache
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RenderBlockMustache(
            $serviceContainer->get(FindComponent::class),
            $serviceContainer->get(FileResolver::class)
        );
    }
}
