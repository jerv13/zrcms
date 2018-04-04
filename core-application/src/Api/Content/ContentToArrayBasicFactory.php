<?php

namespace Zrcms\CoreApplication\Api\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\PropertiesToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ContentToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ContentToArrayBasic(
            $serviceContainer->get(PropertiesToArray::class)
        );
    }
}
