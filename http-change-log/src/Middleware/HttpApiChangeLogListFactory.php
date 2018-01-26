<?php

namespace Zrcms\HttpChangeLog\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiChangeLogListFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiChangeLogList
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiChangeLogList(
            $serviceContainer->get(GetHumanReadableChangeLogByDateRange::class)
        );
    }
}
