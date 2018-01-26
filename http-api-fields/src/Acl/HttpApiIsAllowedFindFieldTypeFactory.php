<?php

namespace Zrcms\HttpApiFields\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedFindFieldTypeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedFindFieldType
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedFindFieldType(
            $serviceContainer->get(IsAllowedAny::class),
            [],
            HttpApiIsAllowedFindFieldType::NAME,
            HttpApiIsAllowedFindFieldType::DEFAULT_NOT_ALLOWED_STATUS,
            IsDebug::invoke()
        );
    }
}
