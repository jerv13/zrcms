<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Model;

use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutComponentConfigFields extends ComponentConfigFields
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::LOCATION => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
            self::COMPONENT_CONFIG_READER => '',
        ];
}
