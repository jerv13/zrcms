<?php

namespace Zrcms\HttpChangeLog;

use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreApplication\Api\ChangeLog\ChangeLogEventToString;
use Zrcms\CoreApplication\Api\ChangeLog\GetContentChangeLogComposite;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;
use Zrcms\CoreContainer\Api\ChangeLog\GetChangeLogByDateRange as ContainerGetChangeLogByDateRange;
use Zrcms\CorePage\Api\ChangeLog\GetChangeLogByDateRange as PageGetChangeLogByDateRange;
use Zrcms\CoreRedirect\Api\ChangeLog\GetChangeLogByDateRange as RedirectGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\ChangeLog\GetChangeLogByDateRange as SiteGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreTheme\Api\ChangeLog\GetChangeLogByDateRange as ThemeGetChangeLogByDateRange;
use Zrcms\HttpChangeLog\Middleware\ChangeLogList;
use Zrcms\HttpChangeLog\Middleware\IsAllowedReadChangeLog;

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
                    /**
                     * ChangeLog
                     */
                    GetChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogComposite::class,
                        'calls' => [
                            ['addSubordinate', [PageGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ContainerGetChangeLogByDateRange::class]],
                            ['addSubordinate', [SiteGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ThemeGetChangeLogByDateRange::class]],
                            ['addSubordinate', [RedirectGetChangeLogByDateRange::class]],
                        ],
                    ],
                    GetHumanReadableChangeLogByDateRange::class => [
                        'arguments' => [
                            GetChangeLogByDateRange::class,
                            ChangeLogEventToString::class,
                        ]
                    ],

                    ChangeLogEventToString::class => [
                        'class' => ChangeLogEventToString::class,
                        'arguments' => [
                            FindSiteCmsResource::class
                        ],
                    ],

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
