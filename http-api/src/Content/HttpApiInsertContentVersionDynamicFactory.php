<?php

namespace Zrcms\HttpApi\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Debug\IsDebug;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiInsertContentVersionDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiInsertContentVersionDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiInsertContentVersionDynamic(
            $serviceContainer,
            $serviceContainer->get(GetUserIdByRequest::class),
            $serviceContainer->get(ContentVersionToArray::class),
            IsDebug::invoke()
        );
    }
}
