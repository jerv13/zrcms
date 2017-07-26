<?php

namespace Zrcms\ContentCountry\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCountry\Model\CountryVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCountryVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return CountryVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
