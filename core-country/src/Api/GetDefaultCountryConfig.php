<?php

namespace Zrcms\CoreCountry\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreCountry\Model\Country;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDefaultCountryConfig implements GetDefaultCountry
{
    protected $defaultCountryConfig;

    /**
     * @param array $defaultCountryConfig
     */
    public function __construct(
        array $defaultCountryConfig
    ) {
        $this->defaultCountryConfig = $defaultCountryConfig;
    }

    /**
     * @return Country
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Throwable
     */
    public function __invoke(): Country
    {
        return new Country(
            Property::getRequired(
                $this->defaultCountryConfig,
                'iso3'
            ),
            Property::getRequired(
                $this->defaultCountryConfig,
                'iso2'
            ),
            Property::getRequired(
                $this->defaultCountryConfig,
                'name'
            )
        );
    }
}
