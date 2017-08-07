<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLayout extends PropertiesContent
{
    const THEME_NAME = 'themeName';
    const NAME = 'name';

    const RENDERER = 'renderer';
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDER_TAG_NAME_PARSER = 'renderTagNameParser';
    const HTML = 'html';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::THEME_NAME => '',
            self::RENDERER => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDER_TAG_NAME_PARSER => '',
            self::HTML => '',
        ];
}
