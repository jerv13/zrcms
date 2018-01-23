<?php

namespace Zrcms\HttpApi\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindContentVersionDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindContentVersionDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindContentVersionDynamic(
            $serviceContainer,
            $serviceContainer->get(ContentVersionToArray::class),
            404,
            IsDebug::invoke()
        );
    }
}
