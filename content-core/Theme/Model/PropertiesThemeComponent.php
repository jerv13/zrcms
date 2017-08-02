<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesThemeComponent extends PropertiesComponent
{
    const LAYOUT = 'layout';
    const LAYOUT_VARIATIONS = 'layoutVariations';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::LOCATION => '',
            self::LAYOUT => '',
            self::LAYOUT_VARIATIONS => [],
        ];
}
