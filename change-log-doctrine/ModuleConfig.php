<?php

namespace Zrcms\ChangeLogDoctrine;

use Doctrine\ORM\EntityManager;
use Zrcms\ChangeLogDoctrine\Api\GetContentChangeLogByDateRange;
use Zrcms\ChangeLogDoctrine\Api\GetContentChangeLogByDateRangeBasic;
use Zrcms\ChangeLogDoctrine\Api\RowDescriberZrcmsCmsResource;
use Zrcms\ChangeLogDoctrine\Api\RowDescriberZrcmsContentVersion;

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
                    GetContentChangeLogByDateRange::class => [
                        'class' => GetContentChangeLogByDateRangeBasic::class,
                        'arguments' => [
                            EntityManager::class,
                            ['literal' => []]
                        ],
                        'calls' => [
                            'addSourceTable' => [
                                ['literal' => 'zrcms_core_page_resource_history'],
                                ['literal' => 'page'],
                                RowDescriberZrcmsResource::class
                            ],
                            'addSourceTable' => [
                                ['literal' => 'zrcms_core_page_version'],
                                ['literal' => 'page'],
                                RowDescriberZrcmsContentVersion::class
                            ]
                        ]
                    ]
                ],
            ],
        ];
    }
}
