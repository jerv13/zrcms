<?php

namespace Zrcms\CoreBlock\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigBlockBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentConfigBlockBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');
        $pluginConfigBc = $config['rcmPlugin'];
        return new ReadComponentConfigBlockBc(
            $pluginConfigBc,
            $serviceContainer->get(PrepareComponentConfigBlock::class)
        );
    }
}
