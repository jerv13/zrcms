<?php

namespace Zrcms\HttpLocale;

use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpLocale\Middleware\LocaleFromSite;
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
                    LocaleFromSite::class => [
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
