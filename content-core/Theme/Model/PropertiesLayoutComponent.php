<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLayoutComponent extends PropertiesComponent
{
    const THEME_NAME = 'themeName';
    const HTML = 'html';
    const RENDERER = 'renderer';
    const RENDER_DATA_GETTER = 'renderDataGetter';
    const RENDER_TAG_NAME_PARSER = 'renderTagNameParser';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::THEME_NAME => '',
            self::HTML => '',
            self::RENDERER => '',
            self::RENDER_DATA_GETTER => '',
            self::RENDER_TAG_NAME_PARSER => '',
        ];
}
