<?php

namespace Zrcms\CoreApplicationState;

use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CoreApplicationState\Api\GetApplicationStateByConfigFactory;

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
        return [
            'dependencies' => [
                'config_factories' => [
                    GetApplicationState::class => [
                        'factory' => GetApplicationStateByConfigFactory::class,
                    ],
                ],
            ],

            /**
             * ===== ZRCMS Application State =====
             */
            'zrcms-application-state' => [
                /* '{key}' => '{GetApplicationStateServiceName}' */
            ],
        ];
    }
}
