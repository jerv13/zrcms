<?php

namespace Zrcms\HttpApiView;

use Zrcms\HttpApiView\Content\GetViewByRequestHttpApi;
use Zrcms\HttpApiView\Content\GetViewByRequestHttpApiFactory;

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
                    GetViewByRequestHttpApi::class => [
                        'factory' => GetViewByRequestHttpApiFactory::class
                    ],
                ],
            ],
        ];
    }
}
