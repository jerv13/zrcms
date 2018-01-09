<?php

namespace Zrcms\HttpApiView;

use Zrcms\HttpApiView\Content\HttpApiGetViewByRequest;
use Zrcms\HttpApiView\Content\HttpApiGetViewByRequestFactory;

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
                    HttpApiGetViewByRequest::class => [
                        'factory' => HttpApiGetViewByRequestFactory::class
                    ],
                ],
            ],
        ];
    }
}
