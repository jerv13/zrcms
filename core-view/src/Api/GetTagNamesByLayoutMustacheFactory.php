<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Reliv\CacheRat\Service\CacheArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTagNamesByLayoutMustacheFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetTagNamesByLayoutMustache
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetTagNamesByLayoutMustache(
            $serviceContainer->get(CacheArray::class),
            GetTagNamesByLayoutMustache::CACHE_KEY,
            GetTagNamesByLayoutMustache::CACHE_TTL
        );
    }
}
