<?php

namespace Zrcms;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModulesConfigFields
{
    /**
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            new \Zrcms\ValidationRatZrcms\ModuleConfigFields(),
            new \Zrcms\ServiceAlias\ModuleConfigFields(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
