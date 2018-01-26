<?php

namespace Zrcms\HttpApplicationState;

use Zrcms\HttpApplicationState\Acl\HttpApiIsAllowedApplicationState;
use Zrcms\HttpApplicationState\Middleware\HttpApplicationState;

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
                'zrcms.api.application-state.{zrcms-application-state-host}.{zrcms-application-state-path:.*}' => [
                    'name' => 'zrcms.api.application-state.{zrcms-application-state-host}.{zrcms-application-state-path:.*}',
                    'path' => '/zrcms/api/application-state/{zrcms-application-state-host}/{zrcms-application-state-path:.*}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedApplicationState::class,
                        'api' => HttpApplicationState::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Get the application state for a give host and path',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                [
                                    'name' => 'zrcms-application-state-host',
                                    'in' => 'path',
                                    'description' => 'Host (I.E. example.com)',
                                    'required' => true,
                                    'type' => 'string',
                                    'format' => 'string',
                                ],
                                [
                                    'name' => 'zrcms-application-state-path:.*',
                                    'in' => 'path',
                                    'description' => 'Path on requested host (I.E. /home)',
                                    'required' => true,
                                    'type' => 'string',
                                    'format' => 'string',
                                ],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
