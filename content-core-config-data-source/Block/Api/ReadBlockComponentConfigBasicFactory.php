<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadBlockComponentConfigBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadBlockComponentConfigBasic(
            $serviceContainer
        );
    }
}
