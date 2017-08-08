<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsHeadComponentConfigApplicationConfigBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewLayoutTagsHeadComponentConfigApplicationConfigBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $applicationConfig = $config['zrcms-head'];
        $applicationConfigBc = $config['Rcm']['HtmlIncludes'];

        return new ReadViewLayoutTagsHeadComponentConfigApplicationConfigBc(
            $applicationConfig,
            $applicationConfigBc
        );
    }
}
