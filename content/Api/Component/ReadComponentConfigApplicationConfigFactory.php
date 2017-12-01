<?php

namespace Zrcms\Content\Api\Component;

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
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms-components'];

        return new ReadComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
