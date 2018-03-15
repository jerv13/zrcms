<?php

namespace Zrcms\HttpApiSite;

use Zrcms\HttpApiSite\CmsResource\HttpApiFindSiteCmsResourceByHostDynamic;
use Zrcms\HttpApiSite\CmsResource\HttpApiFindSiteCmsResourceByHostDynamicFactory;

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
                    HttpApiFindSiteCmsResourceByHostDynamic::class => [
                        'factory' => HttpApiFindSiteCmsResourceByHostDynamicFactory::class
                    ],
                ],
            ],
        ];
    }
}
