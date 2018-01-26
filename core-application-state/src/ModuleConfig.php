<?php

namespace Zrcms\CoreApplicationState;

use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\CoreApplicationState\Api\GetApplicationStateByConfigFactory;
use Zrcms\CoreApplicationState\Api\Render\RenderScriptTagApplicationState;
use Zrcms\CoreApplicationState\Api\Render\RenderScriptTagApplicationStateFactory;

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
                    RenderScriptTagApplicationState::class => [
                        'factory' => RenderScriptTagApplicationStateFactory::class,
                    ],
                    GetApplicationState::class => [
                        'factory' => GetApplicationStateByConfigFactory::class,
                    ],
                ],
            ],
        ];
    }
}
