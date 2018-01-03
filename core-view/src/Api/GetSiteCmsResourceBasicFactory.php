<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteCmsResourceBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetSiteCmsResourceBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetSiteCmsResourceBasic(
            $serviceContainer->get(FindSiteCmsResourceByHost::class)
        );
    }
}
