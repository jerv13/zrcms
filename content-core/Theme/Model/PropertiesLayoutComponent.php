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
        ];
}
