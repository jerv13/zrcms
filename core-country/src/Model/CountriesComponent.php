<?php

namespace Zrcms\CoreCountry\Model;

use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentAbstract;

class CountriesComponent extends ComponentAbstract implements Component
{
    /**
     * @return Country[]
     */
    public function getCountries(): array
    {
        $countries = [];
        foreach ($this->properties['countries'] as $iso3 => $value) {
            $countries[$iso3] = $this->findCountry($iso3, null);
        }

        return $countries;
    }

    /**
     * @return array
     */
    public function getCountriesArray(): array
    {
        return $this->properties['countries'];
    }

    /**
     * @param string $iso3
     * @param null   $default
     *
     * @return Country|null
     */
    public function findCountry(string $iso3, $default = null)
    {
        $countryArray = $this->findCountryArray($iso3, null);

        if (empty($countryArray)) {
            return $default;
        }

        return $this->buildCountry($countryArray);
    }

    /**
     * @param string $iso3
     * @param null   $default
     *
     * @return array
     */
    public function findCountryArray(string $iso3, $default = null)
    {
        if (array_key_exists($iso3, $this->properties['countries'])) {
            return $this->properties['countries'][$iso3];
        }

        return $default;
    }

    /**
     * @param string $iso2
     * @param null   $default
     *
     * @return null|Country
     */
    public function findCountryByIso2(string $iso2, $default = null)
    {
        $countryArray = $this->findCountryArrayByIso2($iso2, null);

        if (empty($countryArray)) {
            return $default;
        }

        return $this->buildCountry($countryArray);
    }

    /**
     * @param string $iso2
     * @param null   $default
     *
     * @return array
     */
    public function findCountryArrayByIso2(string $iso2, $default = null)
    {
        $result = $this->filterCountryArray('iso2', $iso2);

        if (count($result) > 0) {
            return $result[0];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return null|Country
     */
    public function findCountryByName(string $name, $default = null)
    {
        $countryArray = $this->findCountryArrayByName($name, null);

        if (empty($countryArray)) {
            return $default;
        }

        return $this->buildCountry($countryArray);
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed|null
     */
    public function findCountryArrayByName(string $name, $default = null)
    {
        $result = $this->filterCountryArray('name', $name);

        if (count($result) > 0) {
            return $result[0];
        }

        return $default;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return array
     */
    public function filterCountryArray($key, $value)
    {
        $result = array_filter(
            $this->properties['countries'],
            function ($countryArray) use ($key, $value) {
                if (array_key_exists($key, $countryArray) && $countryArray[$key] == $value) {
                    return true;
                }

                return false;
            }
        );

        return $result;
    }

    /**
     * @param array $countryArray
     *
     * @return Country
     */
    public function buildCountry(array $countryArray)
    {
        return new Country(
            $countryArray['iso3'],
            $countryArray['iso2'],
            $countryArray['name']
        );
    }
}
