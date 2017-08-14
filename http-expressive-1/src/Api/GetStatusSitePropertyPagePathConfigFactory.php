<?php

namespace Zrcms\HttpExpressive1\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetStatusSitePropertyPagePathConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetStatusSitePropertyPagePath
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('Config');

        return new GetStatusSitePropertyPagePathConfig(
            $config['zrcms-status-site-property-page-path']
        );
    }
}
