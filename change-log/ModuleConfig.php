<?php

namespace Zrcms\ChangeLog;

use Doctrine\ORM\EntityManager;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\ChangeLog\Api\GetHumanReadableChangeLogByDateRange;
use Zrcms\ChangeLog\Middleware\ChangeLogList;
use Zrcms\ChangeLog\Middleware\IsAllowedReadChangeLog;
use Zrcms\ChangeLog\Api\ChangeLogEventToString;
use Zrcms\ChangeLog\Api\GetContentChangeLogByDateRangeBasic;
use Zrcms\ChangeLog\Api\GetContentChangeLogComposite;
use Zrcms\ChangeLog\Middleware\ChangeLogHtml;
use Zrcms\Content\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResource;
use Zrcms\ContentCore\Page\Api\ChangeLog\GetChangeLogByDateRange as PageGetChangeLogByDateRange;
use Zrcms\ContentCore\Container\Api\ChangeLog\GetChangeLogByDateRange as ContainerGetChangeLogByDateRange;
use Zrcms\ContentCore\Site\Api\ChangeLog\GetChangeLogByDateRange as SiteGetChangeLogByDateRange;
use Zrcms\ContentCore\Theme\Api\ChangeLog\GetChangeLogByDateRange as ThemeGetChangeLogByDateRange;
use Zrcms\ContentRedirect\Api\ChangeLog\GetChangeLogByDateRange as RedirectGetChangeLogByDateRange;

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
            'routes' => [
                '/zrcms/change-log' => [
                    'name' => '/zrcms/change-log',
                    //Usage Note: For a friendly HTML UI, try adding ?days=30&content-type=text%2Fhtml
                    'path' => '/zrcms/change-log',
                    'middleware' => [
                        //@TODO make this redirect to login page if not logged in
                        IsAllowedReadChangeLog::class,
                        ChangeLogList::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
            'dependencies' => [
                'config_factories' => [
                    ChangeLogList::class => [
                        'arguments' => [
                            GetHumanReadableChangeLogByDateRange::class
                        ]
                    ],
                    GetHumanReadableChangeLogByDateRange::class => [
                        'arguments' => [
                            GetChangeLogByDateRange::class,
                            ChangeLogEventToString::class
                        ]
                    ],
                    GetChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogComposite::class,
                        'calls' => [
                            ['addSubordinate', [PageGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ContainerGetChangeLogByDateRange::class]],
                            ['addSubordinate', [SiteGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ThemeGetChangeLogByDateRange::class]],
                            ['addSubordinate', [RedirectGetChangeLogByDateRange::class]],
                        ]
                    ],
                    ChangeLogEventToString::class => [
                        'class' => ChangeLogEventToString::class,
                        'arguments' => [
                            FindSiteCmsResource::class
                        ],
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
