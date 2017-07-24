<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewComponentConfigApplicationConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewComponentConfigApplicationConfig
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms']['views'];

        return new ReadViewComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
