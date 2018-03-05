<?php

namespace Zrcms\ServiceAlias\Api\Validator;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceAliasRegistry;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsZrcmsServiceAliasFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateIsZrcmsServiceAlias
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateIsZrcmsServiceAlias(
            $serviceContainer->get(GetServiceAliasRegistry::class)
        );
    }
}
