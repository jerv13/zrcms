<?php

namespace Zrcms\LocaleZrcms\Api;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreCountry\Model\CountriesComponent;
use Zrcms\CoreCountry\Model\Country;
use Zrcms\CoreLanguage\Model\Language;
use Zrcms\CoreLanguage\Model\LanguagesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LocaleFromCountryLanguageCore implements LocaleFromCountryLanguage
{
    protected $findComponent;
    protected $countryMethodMap
        = [
            'iso3' => 'findCountry',
            'iso2' => 'findCountryByIso2',
            'name' => 'findCountryByName',
        ];

    protected $languageMethodMap
        = [
            'iso639_2t' => 'findLanguage',
            'iso639_2b' => 'findLanguageByIso639_2b',
            'iso639_1' => 'findLanguageByIso639_1',
            'name' => 'findLanguageByName',
        ];

    /**
     * @param FindComponent $findComponent
     */
    public function __construct(
        FindComponent $findComponent
    ) {
        $this->findComponent = $findComponent;
    }

    /**
     * @param string $languageCode
     * @param string $countryCode
     * @param string $languageCodeType
     * @param string $countryCodeType
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        string $languageCode,
        string $countryCode,
        string $languageCodeType = 'iso639_2t',
        string $countryCodeType = 'iso3'
    ): string {
        /** @var LanguagesComponent $languagesComponent */
        $languagesComponent = $this->findComponent->__invoke(
            'basic',
            'zrcms-languages'
        );

        /** @var CountriesComponent $countriesComponent */
        $countriesComponent = $this->findComponent->__invoke(
            'basic',
            'zrcms-countries'
        );

        if (empty($languagesComponent) || empty($countriesComponent)) {
            throw new \Exception(
                'Language or country component not found'
            );
        }

        $languageMethod = $this->findLanguageMethod($languageCodeType);

        /** @var Language $language */
        $language = $languagesComponent->$languageMethod($languageCode);

        if (empty($language)) {
            throw new \Exception(
                'Language not found: (' . $languageCode .')'
                . ' type: (' . $languageCodeType .')'
            );
        }

        $countyMethod = $this->findCountryMethod($countryCodeType);

        /** @var Country $country */
        $country = $countriesComponent->$countyMethod($countryCode);

        if (empty($country)) {
            throw new \Exception(
                'Country not found: (' . $countryCode .')'
                . ' type: (' . $countryCodeType .')'
            );
        }

        return
            strtolower($language->getIso6391())
            . '_' .
            strtoupper($country->getIso2());
    }

    /**
     * @param string $languageCodeType
     *
     * @return string
     * @throws \Exception
     */
    protected function findLanguageMethod(string $languageCodeType)
    {
        if (!array_key_exists($languageCodeType, $this->languageMethodMap)) {
            throw new \Exception(
                'No method available for language code type: ' . $languageCodeType
            );
        }

        return $this->languageMethodMap[$languageCodeType];
    }

    /**
     * @param string $countryCodeType
     *
     * @return string
     * @throws \Exception
     */
    protected function findCountryMethod(string $countryCodeType)
    {
        if (!array_key_exists($countryCodeType, $this->countryMethodMap)) {
            throw new \Exception(
                'No method available for country code type: ' . $countryCodeType
            );
        }

        return $this->countryMethodMap[$countryCodeType];
    }
}
