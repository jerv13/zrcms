<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Repository;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewRenderDataGettersFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return FindViewRenderDataGetters
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['layout-render-data-getters'];

        return new FindViewRenderDataGetters(
            $serviceContainer,
            $registryConfig
        );
    }
}
