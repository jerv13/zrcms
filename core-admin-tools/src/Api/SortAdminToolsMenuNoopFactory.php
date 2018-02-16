<?php

namespace Zrcms\CoreAdminTools\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SortAdminToolsMenuNoopFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return SortAdminToolsMenuNoop
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new SortAdminToolsMenuNoop();
    }
}
