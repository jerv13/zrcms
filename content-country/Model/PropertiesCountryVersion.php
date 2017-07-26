<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesCountryVersion extends PropertiesContent
{
    const ISO3 = 'iso3';
    const ISO2 = 'iso2';
    const NAME = 'name';
}
