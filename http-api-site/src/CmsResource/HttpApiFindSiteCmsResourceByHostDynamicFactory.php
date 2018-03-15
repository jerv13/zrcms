<?php

namespace Zrcms\HttpApiSite\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindSiteCmsResourceByHostDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindSiteCmsResourceByHostDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindSiteCmsResourceByHostDynamic(
            $serviceContainer,
            $serviceContainer->get(CmsResourceToArray::class),
            404,
            IsDebug::invoke()
        );
    }
}
