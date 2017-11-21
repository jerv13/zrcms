<?php

namespace Zrcms\ChangeLog;

use Doctrine\ORM\EntityManager;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\ChangeLog\Acl\IsAllowedReadChangeLog;
use Zrcms\ChangeLog\Api\ChangeLogEventToString;
use Zrcms\ChangeLog\Api\GetContentChangeLogByDateRangeBasic;
use Zrcms\ChangeLog\Controller\ChangeLogHtml;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Api\ChangeLog\GetChangeLogByDateRange as PageGetChangeLogByDateRange;
use Zrcms\ContentCoreDoctrineDataSource\Container\Api\ChangeLog\GetChangeLogByDateRange as ContainerGetChangeLogByDateRange;
use Zrcms\ContentCoreDoctrineDataSource\Site\Api\ChangeLog\GetChangeLogByDateRange as SiteGetChangeLogByDateRange;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Api\ChangeLog\GetChangeLogByDateRange as ThemeGetChangeLogByDateRange;

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
            'routes' => [//@TODO should this be somewhere else?
                '/zrcms/change-log/html' => [
                    'name' => '/zrcms/change-log/html',
                    'path' => '/zrcms/change-log/html',
                    'middleware' => [
                        //@TODO make this redirect to login page if not logged in
                        IsAllowedReadChangeLog::class,
                        ChangeLogHtml::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
            'dependencies' => [
                'config_factories' => [
                    ChangeLogHtml::class => [
                        'arguments' => [
                            GetContentChangeLogByDateRange::class,
                            ChangeLogEventToString::class
                        ]
                    ],
                    GetContentChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogByDateRangeBasic::class,
                        'calls' => [
                            ['addSubordinate', [PageGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ContainerGetChangeLogByDateRange::class]],
                            ['addSubordinate', [SiteGetChangeLogByDateRange::class]],
                            ['addSubordinate', [ThemeGetChangeLogByDateRange::class]],
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
