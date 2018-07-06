<?php

namespace Zrcms\CoreBlock\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMergedConfigBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetMergedConfigBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new GetMergedConfigBasic(
            $serviceContainer->get(FindComponent::class)
        );
    }
}
