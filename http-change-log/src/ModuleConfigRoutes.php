<?php

namespace Zrcms\HttpChangeLog;

use Zrcms\HttpChangeLog\Middleware\HttpApiChangeLogList;
use Zrcms\HttpChangeLog\Middleware\HttpChangeLogList;
use Zrcms\HttpChangeLog\Middleware\HttpIsAllowedReadChangeLogIsAllowed;

class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                /*
                 * Usage Note: For a friendly HTML UI, try adding ?days=30&content-type=text%2Fhtml
                 */
                'zrcms.change-log' => [
                    'name' => 'zrcms.change-log',
                    'path' => '/zrcms/change-log',
                    'middleware' => [
                        'acl' => HttpIsAllowedReadChangeLogIsAllowed::class, // over-ride me
                        'controller' => HttpChangeLogList::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                'zrcms.api.change-log' => [
                    'name' => 'zrcms.api.change-log',
                    'path' => '/zrcms/api/change-log',
                    'middleware' => [
                        'acl' => HttpIsAllowedReadChangeLogIsAllowed::class, // over-ride me
                        'api' => HttpApiChangeLogList::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'List change-logs for a number of days',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                [
                                    'name' => 'days',
                                    'in' => 'query',
                                    'description' => 'Days filter param: ?days=30',
                                    'required' => false,
                                    'type' => 'int',
                                    'format' => 'int',
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
