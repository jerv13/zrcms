<?php

namespace Zrcms\Locale;

use Zrcms\Locale\Api\DefaultLocal;
use Zrcms\Locale\Api\LocaleFromCountryLanguage;
use Zrcms\Locale\Api\LocaleFromCountryLanguageCoreFactory;
use Zrcms\Locale\Api\SetLocale;
use Zrcms\Locale\Api\SetLocaleBasicFactory;

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
                    SetLocale::class => [
                        'factory' => SetLocaleBasicFactory::class,
                    ],

                ],
            ],
            'zrcms-locale-default' => DefaultLocal::get()
        ];
    }
}
