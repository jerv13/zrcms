<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @todo   This may NOT be needed
 *
 * @author James Jervis - https://github.com/jerv13
 */
class MutateViewCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return MutateViewComposite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $viewBuilders = $config['zrcms-view-mutator'];

        $viewBuilder = new MutateViewComposite();

        $viewBuilder->addMulti($viewBuilders);

        return $viewBuilder;
    }
}
