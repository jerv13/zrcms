<?php

namespace Zrcms\HttpTest\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRelivServerEnvironmentNoneProduction;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedTestIsAllowedFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsAllowedTestIsAllowed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsAllowedTestIsAllowed(
            $serviceContainer->get(IsAllowedRelivServerEnvironmentNoneProduction::class),
            []
        );
    }
}
