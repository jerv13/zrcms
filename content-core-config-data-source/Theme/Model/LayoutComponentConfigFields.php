<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Model;

use Zrcms\ContentCore\Theme\Model\PropertiesLayoutComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutComponentConfigFields extends ComponentConfigFields
{
    const TEMPLATE_FILE = 'templateFile';

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
            self::TEMPLATE_FILE => '',
        ];
}
