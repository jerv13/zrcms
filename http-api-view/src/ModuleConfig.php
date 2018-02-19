<?php

namespace Zrcms\HttpApiView;

use Zrcms\HttpApiView\Acl\HttpApiIsAllowedGetViewData;
use Zrcms\HttpApiView\Acl\HttpApiIsAllowedGetViewDataFactory;
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
                        'factory' => HttpApiIsAllowedGetViewDataFactory::class,
                    ],
                    HttpApiGetViewData::class => [
                        'factory' => HttpApiGetViewDataFactory::class,
                    ],
                    HttpApiGetViewDataByRequest::class => [
                        'factory' => HttpApiGetViewDataByRequestFactory::class,
                    ],
                ],
            ],
        ];
    }
}
