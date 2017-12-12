<?php

namespace Zrcms\CoreBlock\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryRcmPluginBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentRegistryRcmPluginBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadComponentRegistryRcmPluginBc(
            $serviceContainer->get('config')
        );
    }
}
