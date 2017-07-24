<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadThemeComponentConfigBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadThemeComponentConfigBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadThemeComponentConfigBasic(
            $serviceContainer
        );
    }
}
