<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;

/**
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

        $mutatorConfig = $config['zrcms-view-mutator'];

        return new MutateViewComposite(
            $mutatorConfig,
            $serviceContainer
        );
    }
}
