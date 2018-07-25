<?php

namespace Zrcms\HttpStatusPages\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetStatusPageBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetStatusPageBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetStatusPageBasic(
            $serviceContainer->get(GetSiteCmsResourceByRequest::class),
            $serviceContainer->get(FindComponent::class)
        );
    }
}
