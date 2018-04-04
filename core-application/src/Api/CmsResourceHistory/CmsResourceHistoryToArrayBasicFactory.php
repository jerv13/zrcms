<?php

namespace Zrcms\CoreApplication\Api\CmsResourceHistory;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceHistoryToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return CmsResourceHistoryToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new CmsResourceHistoryToArrayBasic(
            $serviceContainer->get(ContentVersionToArray::class),
            $serviceContainer->get(CmsResourceToArray::class)
        );
    }
}
