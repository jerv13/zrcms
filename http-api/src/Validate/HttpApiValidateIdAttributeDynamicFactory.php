<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;
use Zrcms\ValidationRatZrcms\Api\ValidateId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateIdAttributeDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiValidateIdAttributeDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiValidateIdAttributeDynamic(
            $serviceContainer,
            $serviceContainer->get(ValidateId::class),
            400,
            IsDebug::invoke()
        );
    }
}
