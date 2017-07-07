<?php

namespace Zrcms\Country\Api;

use Zrcms\Country\Model\CountryPublished;

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
