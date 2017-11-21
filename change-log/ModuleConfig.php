<?php

namespace Zrcms\ChangeLog;

use Doctrine\ORM\EntityManager;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\ChangeLog\Acl\IsAllowedReadChangeLog;
use Zrcms\ChangeLog\Api\ChangeLogEventToString;
use Zrcms\ChangeLog\Api\GetContentChangeLogByDateRange;
use Zrcms\ChangeLog\Api\GetContentChangeLogByDateRangeBasic;
use Zrcms\ChangeLog\Controller\ChangeLogHtml;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;

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
                    ChangeLogHtml::class => [
                        'arguments' => [
                            GetContentChangeLogByDateRange::class,
                            ChangeLogEventToString::class
                        ]
                    ],
                    GetContentChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogByDateRangeBasic::class,
                        'calls' => [
                            [
                                'addSubordinate',
                                [
                                    'Zrcms\ContentCore\Page\Api\ChangeLog\GetChangeLogByDateRange'
                                ]
                            ],
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
        ];
    }
}
