<?php

namespace Zrcms\HttpLocale;

use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpLocale\Middleware\HttpLocaleFromSite;
use Zrcms\Locale\Api\SetLocale;

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
                    HttpLocaleFromSite::class => [
                        'arguments' => [
                            SetLocale::class,
                            GetSiteCmsResourceByRequest::class
                        ],
                    ],
                ],
            ],
        ];
    }
}
