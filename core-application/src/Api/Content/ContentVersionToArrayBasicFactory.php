<?php

namespace Zrcms\CoreApplication\Api\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\PropertiesToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ContentVersionToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ContentVersionToArrayBasic(
            $serviceContainer->get(PropertiesToArray::class)
        );
    }
}
