<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Debug\IsDebug;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiUpsertCmsResourceDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiUpsertCmsResourceDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiUpsertCmsResourceDynamic(
            $serviceContainer,
            $serviceContainer->get(GetUserIdByRequest::class),
            $serviceContainer->get(CmsResourceToArray::class),
            IsDebug::invoke()
        );
    }
}
