<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLayoutVersion extends PropertiesLayout
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContentVersion::ID => '',
            self::THEME_NAME => '',
            self::RENDERER => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDER_TAG_NAME_PARSER => '',
            self::HTML => '',
        ];
}
