<?php

namespace Rcms\Core\Country\Api;

use Rcms\Core\Country\Model\CountryPublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCountryPublished
{
    /**
     * @param          $id
     * @param null|int $lockMode
     * @param null|int $lockVersion
     * @param array    $options
     *
     * @return CountryPublished|null
     */
    public function __invoke(
        $id,
        $lockMode = null,
        $lockVersion = null,
        array $options = []
    );
}
