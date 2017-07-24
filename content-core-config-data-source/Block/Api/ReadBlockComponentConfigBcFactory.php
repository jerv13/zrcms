<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadBlockComponentConfigBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');
        $pluginConfigBc = $config['rcmPlugin'];

        return new ReadBlockComponentConfigBc(
            $pluginConfigBc
        );
    }
}
