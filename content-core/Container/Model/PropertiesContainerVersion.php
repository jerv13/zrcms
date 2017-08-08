<?php

namespace Zrcms\ContentCore\Container\Model;

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
            self::ID => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDERER => '',
            self::BLOCK_VERSIONS => [],
        ];
}
