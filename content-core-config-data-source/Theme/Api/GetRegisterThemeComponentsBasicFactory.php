<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterThemeComponentsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetRegisterThemeComponentsBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['themes'];

        return new GetRegisterThemeComponentsBasic(
            $registryConfig,
            $serviceContainer->get(ReadThemeComponentConfig::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
