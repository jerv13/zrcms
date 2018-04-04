<?php

namespace Zrcms\CoreApplication\Api\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Content\ContentVersionToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionsToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ContentVersionsToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ContentVersionsToArrayBasic(
            $serviceContainer->get(ContentVersionToArray::class)
        );
    }
}
