<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourcesPublishedDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindCmsResourcesPublishedDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindCmsResourcesPublishedDynamic(
            $serviceContainer,
            $serviceContainer->get(CmsResourcesToArray::class),
            IsDebug::invoke()
        );
    }
}
