<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesThemeComponent extends PropertiesComponent
{
    const PRIMARY_LAYOUT_NAME = 'primaryLayoutName';
    const LAYOUT_VARIATIONS = 'layoutVariations';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::PRIMARY_LAYOUT_NAME => '',
            self::LAYOUT_VARIATIONS => [],
        ];
}
