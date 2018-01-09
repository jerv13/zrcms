<?php

namespace Zrcms\HttpAssetsApplicationState;

use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationState;
use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationStateFactory;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationState;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationStateFactory;

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
                    HttpApplicationState::class => [
                        'factory' => HttpApplicationStateFactory::class,
                    ],
                ],
            ],
        ];
    }
}
