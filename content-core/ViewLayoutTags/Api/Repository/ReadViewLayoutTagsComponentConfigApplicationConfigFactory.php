<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

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

        $applicationConfig = $config['zrcms']['views'];

        return new ReadViewLayoutTagsComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
