<?php

namespace Zrcms\HttpApiFields\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedApiFindFieldsByModelFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedApiFindFieldsByModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedApiFindFieldsByModel(
            $serviceContainer->get(IsAllowedAny::class),
            [],
            HttpApiIsAllowedApiFindFieldsByModel::NAME,
            HttpApiIsAllowedApiFindFieldsByModel::DEFAULT_NOT_ALLOWED_STATUS,
            IsDebug::invoke()
        );
    }
}
