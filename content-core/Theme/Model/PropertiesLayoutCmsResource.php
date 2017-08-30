<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLayoutCmsResource extends PropertiesCmsResource
{
    const THEME_NAME = 'themeName';
    const NAME = 'name';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION_ID => '',
            self::PUBLISHED => true,
            self::THEME_NAME => '',
            self::NAME => '',
        ];
}
