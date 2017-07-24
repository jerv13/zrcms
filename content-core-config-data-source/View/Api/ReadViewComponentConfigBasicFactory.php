<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewComponentConfigBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewComponentConfigBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadViewComponentConfigBasic(
            $serviceContainer
        );
    }
}
