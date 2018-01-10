<?php

namespace Zrcms\HttpAssetsApplicationState;

use Zrcms\HttpAssetsApplicationState\Acl\HttpApiIsAllowedApplicationState;
use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationState;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationState;

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
                'zrcms.application-state.{host}.{path:.*}' => [
                    'name' => 'zrcms.application-state.{host}.{path:.*}',
                    'path' => '/zrcms/application-state/{host}/{path:.*}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedApplicationState::class,
                        'api' => HttpApplicationState::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET']
                ]
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'config' => [
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
