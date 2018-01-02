<?php

namespace Zrcms\HttpAssetsApplicationState;

use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationState;
use Zrcms\HttpAssetsApplicationState\Middleware\ApplicationState;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.application-state' => [
                    'name' => 'zrcms.application-state',
                    'path' => '/zrcms/application-state',
                    'middleware' => [
                        'middleware' => ApplicationState::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'modules' => [
                        'zrcms.application-state.js' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderScriptTagApplicationState::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
