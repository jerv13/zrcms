<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistoryDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindCmsResourceHistoryDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindCmsResourceHistoryDynamic(
            $serviceContainer,
            $serviceContainer->get(CmsResourceHistoryToArray::class),
            404,
            IsDebug::invoke()
        );
    }
}
