<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Model;

use Zrcms\ContentCore\Theme\Model\PropertiesThemeComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

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
    protected $properties
        = [
            self::NAME => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
            self::PRIMARY_LAYOUT => 'primary',
            self::LAYOUT_LOCATIONS => [],
        ];
}
