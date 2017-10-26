<?php

namespace Zrcms\ContentCore;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            new ModuleConfigBasic(),
            new ModuleConfigBlock(),
            new ModuleConfigContainer(),
            new ModuleConfigPage(),
            new ModuleConfigSite(),
            new ModuleConfigTheme(),
            new ModuleConfigView(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
