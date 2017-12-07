<?php

namespace Zrcms\Cache\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ClearZrcmsCachesBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ClearZrcmsCachesBasic
     */
    public function __invoke($serviceContainer)
    {
        $appConfig = $serviceContainer->get('config');

        return new ClearZrcmsCachesBasic(
            $serviceContainer,
            $appConfig['zrcms-caches']
        );
    }
}
