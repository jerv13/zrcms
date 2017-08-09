<?php

namespace Zrcms\ViewHead\Api\Repository;

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

        $applicationConfig = $config['zrcms-components']['view-layout-tags'];

        $configBc = [
            'meta' => [],
            'script' => [],
            'link' => [],
        ];

        if (array_key_exists('Rcm', $config)) {
            if (array_key_exists('HtmlIncludes', $config['Rcm'])) {
                $configBc['meta'] = $config['Rcm']['HtmlIncludes']['headMetaName'];
                $configBc['script'] =  $config['Rcm']['HtmlIncludes']['scripts'];
                $configBc['link'] =  $config['Rcm']['HtmlIncludes']['stylesheets'];
            }
        }

        return new ReadViewHeadComponentConfigBc(
            $applicationConfig,
            $configBc
        );
    }
}
