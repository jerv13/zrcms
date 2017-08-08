<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContainer extends PropertiesContent
{
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDERER = 'renderer';
    const BLOCK_VERSIONS = 'blockVersions';

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
