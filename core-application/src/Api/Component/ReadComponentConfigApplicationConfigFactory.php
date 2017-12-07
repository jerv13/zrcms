<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigApplicationConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentConfigApplicationConfig
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadComponentConfigApplicationConfig(
            $serviceContainer->get('config')
        );
    }
}
