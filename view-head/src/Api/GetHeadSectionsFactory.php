<?php

namespace Zrcms\ViewHead\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetHeadSectionsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetHeadSections
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('Config');

        return new GetHeadSections(
            $config['zrcms-head-available-sections']
        );
    }
}
