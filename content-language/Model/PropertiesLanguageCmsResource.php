<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLanguageCmsResource extends PropertiesCmsResource
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION_ID => '',
        ];
}
