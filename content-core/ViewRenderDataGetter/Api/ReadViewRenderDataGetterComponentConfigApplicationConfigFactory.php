<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentConfigApplicationConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewRenderDataGetterComponentConfigApplicationConfig
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms']['views'];

        return new ReadViewRenderDataGetterComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
