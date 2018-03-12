<?php

namespace Zrcms\CoreCountry;

use Zrcms\CoreCountry\Api\GetDefaultCountry;
use Zrcms\CoreCountry\Api\GetDefaultCountryConfigFactory;

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
                    GetDefaultCountry::class => [
                        'factory' => GetDefaultCountryConfigFactory::class
                    ],
                ],
            ],
        ];
    }
}
