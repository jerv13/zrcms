<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewByRequestComposite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');
        return new GetViewByRequestComposite(
            $appConfig['zrcms-get-view-by-request-api-list'],
            $serviceContainer
        );
    }
}
