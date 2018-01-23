<?php

namespace Zrcms\HttpApi\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Content\ContentVersionsToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindContentVersionsByDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindContentVersionsByDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindContentVersionsByDynamic(
            $serviceContainer,
            $serviceContainer->get(ContentVersionsToArray::class),
            IsDebug::invoke()
        );
    }
}
