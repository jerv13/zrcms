<?php

namespace Zrcms\HttpExpressive;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleAllConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            new ModuleConfig(),
            new HttpAlwaysConfig(),
            new HttpApiConfig(),
            new HttpApiBasicConfig(),
            new HttpApiSiteConfig(),
            new HttpRenderConfig(),
            new HttpTestModuleConfig(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
