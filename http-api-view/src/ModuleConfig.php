<?php

namespace Zrcms\HttpApiView;

use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpApiView\Acl\HttpApiIsAllowedGetViewData;
use Zrcms\HttpApiView\Content\HttpApiGetViewData;
use Zrcms\HttpApiView\Content\HttpApiGetViewDataByRequest;
use Zrcms\HttpApiView\Content\HttpApiGetViewDataByRequestFactory;
use Zrcms\HttpApiView\Content\HttpApiGetViewDataFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
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
                    HttpApiIsAllowedGetViewData::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'view-get-view-data'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()]
                        ],
                    ],
                    HttpApiGetViewData::class => [
                        'factory' => HttpApiGetViewDataFactory::class
                    ],
                    HttpApiGetViewDataByRequest::class => [
                        'factory' => HttpApiGetViewDataByRequestFactory::class
                    ],
                ],
            ],
        ];
    }
}
