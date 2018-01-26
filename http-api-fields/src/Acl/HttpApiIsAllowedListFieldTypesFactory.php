<?php

namespace Zrcms\HttpApiFields\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedListFieldTypesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedListFieldTypes
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedListFieldTypes(
            $serviceContainer->get(IsAllowedAny::class),
            [],
            HttpApiIsAllowedListFieldTypes::NAME,
            HttpApiIsAllowedListFieldTypes::DEFAULT_NOT_ALLOWED_STATUS,
            IsDebug::invoke()
        );
    }
}
