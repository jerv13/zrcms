<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ThemeComponentConfigFields extends ComponentConfigFields
{
    const PRIMARY_LAYOUT = PropertiesThemeComponent::PRIMARY_LAYOUT_NAME;
    const LAYOUT_LOCATIONS = 'layoutLocations';

    /**
     * Default values
     *
     * @var array
     */
    protected $fields
        = [
            self::NAME => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
            self::PRIMARY_LAYOUT => 'primary',
            self::LAYOUT_LOCATIONS => [],
        ];
}
