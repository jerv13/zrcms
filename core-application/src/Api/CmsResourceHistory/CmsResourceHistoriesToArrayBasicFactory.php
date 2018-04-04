<?php

namespace Zrcms\CoreApplication\Api\CmsResourceHistory;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceHistoriesToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return CmsResourceHistoriesToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new CmsResourceHistoriesToArrayBasic(
            $serviceContainer->get(CmsResourceHistoryToArray::class)
        );
    }
}
