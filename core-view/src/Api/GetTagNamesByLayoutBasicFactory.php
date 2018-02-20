<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTagNamesByLayoutBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetTagNamesByLayoutBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetTagNamesByLayoutBasic(
            $serviceContainer->get(GetServiceFromAlias::class),
            GetTagNamesByLayoutMustache::class
        );
    }
}
