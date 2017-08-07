<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContainerVersion extends PropertiesContainer
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContentVersion::ID => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDERER => '',
        ];
}
