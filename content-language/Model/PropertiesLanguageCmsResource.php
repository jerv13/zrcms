<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLanguageCmsResource extends PropertiesCmsResource
{
    const ISO_639_2T = 'iso639_2t';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::ISO_639_2T => '',
            self::CONTENT_VERSION_ID => '',
        ];
}
