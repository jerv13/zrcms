<?php

namespace Zrcms\HttpSiteExists;

use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpSiteExists\Middleware\SiteExists;

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
                    SiteExists::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
