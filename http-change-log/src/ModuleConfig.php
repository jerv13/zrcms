<?php

namespace Zrcms\HttpChangeLog;

use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreApplication\Api\ChangeLog\ChangeLogEventToString;
use Zrcms\CoreApplication\Api\ChangeLog\GetContentChangeLogComposite;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;
use Zrcms\CoreSiteContainer\Api\ChangeLog\GetSiteContainerChangeLogByDateRange as SiteContainerGetChangeLogByDateRange;
use Zrcms\CorePage\Api\ChangeLog\GetPageChangeLogByDateRange as PageGetChangeLogByDateRange;
use Zrcms\CoreRedirect\Api\ChangeLog\GetRedirectChangeLogByDateRange as RedirectGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\ChangeLog\GetSiteChangeLogByDateRange as SiteGetChangeLogByDateRange;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreTheme\Api\ChangeLog\GetLayoutChangeLogByDateRange as ThemeGetChangeLogByDateRange;
use Zrcms\HttpChangeLog\Middleware\HttpApiChangeLogList;
use Zrcms\HttpChangeLog\Middleware\HttpApiChangeLogListFactory;
use Zrcms\HttpChangeLog\Middleware\HttpChangeLogList;
use Zrcms\HttpChangeLog\Middleware\HttpIsAllowedReadChangeLogIsAllowed;

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
                    /**
                     * ChangeLog
                     */
                    GetChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogComposite::class,
                        'calls' => [
                            ['addSubordinate', [PageGetChangeLogByDateRange::class]],
                            ['addSubordinate', [SiteContainerGetChangeLogByDateRange::class]],
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

                    HttpApiChangeLogList::class => [
                        'factory' => HttpApiChangeLogListFactory::class,
                    ],

                    HttpChangeLogList::class => [
                        'arguments' => [
                            GetHumanReadableChangeLogByDateRange::class
                        ]
                    ],
                    HttpIsAllowedReadChangeLogIsAllowed::class => [
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
