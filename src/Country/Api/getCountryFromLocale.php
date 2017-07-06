<?php

namespace Rcms\Core\Country\Api;

use Rcms\Core\Country\Model\Country;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface getCountryFromLocale
{
    /**
     * @param string $locale
     * @param array  $options
     *
     * @return Country|null
     */
    public function __invoke(string $locale, $options = []);
}
