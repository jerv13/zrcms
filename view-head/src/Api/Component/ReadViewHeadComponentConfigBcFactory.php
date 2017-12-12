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
        $applicationConfig = $serviceContainer->get('config');

        $configBc = [];

        if (array_key_exists('Rcm', $applicationConfig)) {
            if (array_key_exists('HtmlIncludes', $applicationConfig['Rcm'])) {
                $configBc = $applicationConfig['Rcm']['HtmlIncludes'];
            }
        }

        return new ReadViewHeadComponentConfigBc(
            $applicationConfig,
            $configBc
        );
    }
}
