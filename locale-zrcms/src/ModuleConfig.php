<?php

namespace Zrcms\LocaleZrcms;

use Zrcms\LocaleZrcms\Api\LocaleFromCountryLanguage;
use Zrcms\LocaleZrcms\Api\LocaleFromCountryLanguageCoreFactory;

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
                    LocaleFromCountryLanguage::class => [
                        'factory' => LocaleFromCountryLanguageCoreFactory::class,
                    ],
                ],
            ],
        ];
    }
}
