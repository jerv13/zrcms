<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\ContentCore\Basic\Model\BasicComponent;
use Zrcms\ContentCore\Basic\Model\BasicComponentAbstract;

class CountriesComponent extends BasicComponentAbstract implements BasicComponent
{
    /**
     * @return Country[]
     */
    public function getCountries(): array
    {
        $countries = [];
        foreach ($this->properties['countries'] as $iso3 => $value) {
            $countries[$iso3] = $this->getCountry($iso3, null);
        }

        return $countries;
    }

    /**
     * @param string $iso3
     * @param null   $default
     *
     * @return array
     */
    public function getCountriesArray(string $iso3, $default = null): array
    {
        return $this->properties['countries'];
    }

    /**
     * @param string $iso3
     * @param null   $default
     *
     * @return Country|null
     */
    public function getCountry(string $iso3, $default = null)
    {
        $countryArray = $this->getCountryArray($iso3, null);

        if (empty($countryArray)) {
            return $default;
        }

        return new Country(
            $countryArray['iso3'],
            $countryArray['iso2'],
            $countryArray['name']
        );
    }

    /**
     * @param string $iso3
     * @param null   $default
     *
     * @return array
     */
    public function getCountryArray(string $iso3, $default = null)
    {
        if (array_key_exists($iso3, $this->properties['countries'])) {
            return $this->properties['countries'][$iso3];
        }

        return $default;
    }
}
