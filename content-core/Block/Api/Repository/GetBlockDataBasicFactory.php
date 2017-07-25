<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockDataBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetBlockDataBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetBlockDataBasic(
            $serviceContainer,
            $serviceContainer->get(FindBlockComponent::class)
        );
    }
}
