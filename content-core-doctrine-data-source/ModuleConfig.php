<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            new ModuleConfigContainer(),
            new ModuleConfigPage(),
            new ModuleConfigSite(),
            new ModuleConfigTheme(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
