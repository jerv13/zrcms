<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\ViewBuilder\BuildRequestedView;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategy;
use Zrcms\CoreView\Api\ViewBuilder\MutateView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestDefaultFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewByRequestDefault
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetViewByRequestDefault(
            $serviceContainer->get(DetermineViewStrategy::class),
            $serviceContainer->get(BuildRequestedView::class),
            $serviceContainer->get(MutateView::class)
        );
    }
}
