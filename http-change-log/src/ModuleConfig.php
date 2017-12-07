<?php

namespace Zrcms\HttpChangeLog;

use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\HttpChangeLog\Middleware\ChangeLogList;
use Zrcms\HttpChangeLog\Middleware\IsAllowedReadChangeLog;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;

class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    ChangeLogList::class => [
                        'arguments' => [
                            GetHumanReadableChangeLogByDateRange::class
                        ]
                    ],
                    IsAllowedReadChangeLog::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'change-log',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
                                ]
                            ],
                            ['literal' => 'change-log-read']
                        ],
                    ],
                ],
            ],

            'routes' => [
                '/zrcms/change-log' => [
                    'name' => '/zrcms/change-log',
                    //Usage Note: For a friendly HTML UI, try adding ?days=30&content-type=text%2Fhtml
                    'path' => '/zrcms/change-log',
                    'middleware' => [
                        //@TODO (in Over-ride in app to do this) make this redirect to login page if not logged
                        IsAllowedReadChangeLog::class,
                        ChangeLogList::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'RcmUser' => [
                'Acl\Config' => [
                    'ResourceProviders' => [
                        'change-log-resources' => [
                            'change-log' => [
                                'resourceId' => 'change-log',
                                'parentResourceId' => null,
                                'privileges' => [
                                    'read',
                                    'update',
                                    'create',
                                    'delete',
                                    'execute',
                                ],
                                'name' => 'Change log access',
                                'description' => 'Change log access',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
