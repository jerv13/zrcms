<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Container\ContainerInterface;

/**
 * @todo   This may NOT be needed
 *
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildViewComposite
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $viewBuilders = $config['zrcms-view-builders'];

        $viewBuilder = new BuildViewComposite();

        $viewBuilder->addMulti($viewBuilders);

        return $viewBuilder;
    }
}
