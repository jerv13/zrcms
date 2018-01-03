<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @todo   This may NOT be needed
 *
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildViewComposite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $viewBuilders = $config['zrcms-view-builders'];

        $viewBuilder = new BuildViewComposite();

        $viewBuilder->addMulti($viewBuilders);

        return $viewBuilder;
    }
}
