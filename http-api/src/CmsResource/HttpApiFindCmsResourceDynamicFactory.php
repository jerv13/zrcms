<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindCmsResourceDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindCmsResourceDynamic(
            $serviceContainer,
            $serviceContainer->get(CmsResourceToArray::class),
            404,
            IsDebug::invoke()
        );
    }
}
