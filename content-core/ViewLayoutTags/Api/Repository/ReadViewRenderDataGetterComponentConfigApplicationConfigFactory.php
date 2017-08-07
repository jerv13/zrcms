<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsGetterComponentConfigApplicationConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewLayoutTagsGetterComponentConfigApplicationConfig
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms']['views'];

        return new ReadViewLayoutTagsGetterComponentConfigApplicationConfig(
            $applicationConfig
        );
    }
}
