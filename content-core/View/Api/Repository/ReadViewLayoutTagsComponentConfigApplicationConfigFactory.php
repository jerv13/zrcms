<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentConfigApplicationConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewLayoutTagsComponentConfigApplicationConfig
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms-components']['view-layout-tags'];

        return new ReadViewLayoutTagsComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
