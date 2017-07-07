<?php

namespace Zrcms\Country\Api;

use Zrcms\Country\Model\CountryPublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCountryPublished
{
    /**
     * @param          $iso3
     * @param array    $options
     *
     * @return CountryPublished|null
     */
    public function __invoke(
        $iso3,
        array $options = []
    );
}
