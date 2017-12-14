<?php

namespace Zrcms\ViewHead\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetAvailableHeadSectionsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetAvailableHeadSections
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('Config');

        return new GetAvailableHeadSections(
            $config['zrcms-head-available-sections']
        );
    }
}
