<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildViewBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new BuildViewBasic(
            $serviceContainer->get(MutateView::class)
        );
    }
}
