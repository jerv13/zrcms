<?php

namespace Zrcms\HttpSiteExists;

use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpSiteExists\Middleware\HttpSiteExists;

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
                    HttpSiteExists::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
