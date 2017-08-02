<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesCountryVersion extends PropertiesContent
{
    const ISO3 = 'iso3';
    const ISO2 = 'iso2';
    const NAME = 'name';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::ISO3 => '',
            self::ISO2 => '',
            self::NAME => '',
        ];
}
