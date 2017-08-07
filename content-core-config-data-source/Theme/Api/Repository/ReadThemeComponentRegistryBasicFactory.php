<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadThemeComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadThemeComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms']['themes'];

        return new ReadThemeComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class)
        );
    }
}
