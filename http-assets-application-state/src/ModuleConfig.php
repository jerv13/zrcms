<?php

namespace Zrcms\HttpAssetsApplicationState;

use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationState;
use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationStateFactory;
use Zrcms\HttpAssetsApplicationState\Middleware\ApplicationState;
use Zrcms\HttpAssetsApplicationState\Middleware\ApplicationStateFactory;

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
                    ApplicationState::class => [
                        'factory' => ApplicationStateFactory::class,
                    ],
                ],
            ],
        ];
    }
}
