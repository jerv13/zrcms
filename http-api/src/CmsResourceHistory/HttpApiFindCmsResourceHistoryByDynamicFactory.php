<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoriesToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistoryByDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindCmsResourceHistoryByDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindCmsResourceHistoryByDynamic(
            $serviceContainer,
            $serviceContainer->get(CmsResourceHistoriesToArray::class),
            IsDebug::invoke()
        );
    }
}
