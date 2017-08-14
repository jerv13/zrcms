<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesCountryCmsResource extends PropertiesCmsResource
{
    const ISO3 = 'iso3';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::ISO3 => '',
            self::CONTENT_VERSION_ID => '',
        ];
}
