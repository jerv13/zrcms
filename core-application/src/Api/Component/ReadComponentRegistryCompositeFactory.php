<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentRegistryComposite
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $readComponentRegistryServiceNames = $config['zrcms-component-registry-readers'];

        return new ReadComponentRegistryComposite(
            $serviceContainer,
            $readComponentRegistryServiceNames,
            $serviceContainer->get(Cache::class),
            ReadComponentRegistryComposite::DEFAULT_CACHE_KEY
        );
    }
}
