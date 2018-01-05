<?php

namespace Zrcms\Locale\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LocaleFromCountryLanguage
{
    /**
     * @param string $languageCode
     * @param string $countryCode
     * @param string $languageCodeType
     * @param string $countryCodeType
     *
     * @return string
     */
    public function __invoke(
        string $languageCode,
        string $countryCode,
        string $languageCodeType = 'iso639_2t',
        string $countryCodeType = 'iso3'
    ): string;
}
