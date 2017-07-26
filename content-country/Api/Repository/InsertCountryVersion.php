<?php

namespace Zrcms\ContentCountry\Api\Repository;

use Zrcms\Content\Api\Repository\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCountry\Model\CountryVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertCountryVersion extends InsertContentVersion
{
    /**
     * @param CountryVersion|ContentVersion $countryVersion
     * @param array                      $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $countryVersion,
        array $options = []
    ): ContentVersion;
}
