<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadLayoutComponentConfigBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadLayoutComponentConfigBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadLayoutComponentConfigBasic(
            $serviceContainer
        );
    }
}
