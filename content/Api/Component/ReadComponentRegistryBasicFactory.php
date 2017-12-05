<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-components'];

        return new ReadComponentRegistryBasic(
            $registry,
            $serviceContainer->get(ReadComponentConfigByStrategy::class),
            $serviceContainer->get(Cache::class),
            ReadComponentRegistryBasic::CACHE_KEY
        );
    }
}
