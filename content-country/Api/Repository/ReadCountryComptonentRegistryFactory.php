<?php

namespace Zrcms\ContentCountry\Api\Repository;

class ReadCountryComptonentRegistryFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadBlockComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-components']['blocks'];

        return new ReadBlockComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
