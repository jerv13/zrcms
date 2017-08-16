<?php

namespace Zrcms\ContentCore\Basic\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBasicComponentConfigApplicationConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadBasicComponentConfigApplicationConfig
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms-components']['basic'];

        return new ReadBasicComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
