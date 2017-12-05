<?php

namespace Zrcms\ViewHead\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewHeadComponentConfigBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewHeadComponentConfigBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms-components'];

        $configBc = [];

        if (array_key_exists('Rcm', $config)) {
            if (array_key_exists('HtmlIncludes', $config['Rcm'])) {
                $configBc = $config['Rcm']['HtmlIncludes'];
            }
        }

        return new ReadViewHeadComponentConfigBc(
            $applicationConfig,
            $configBc
        );
    }
}
