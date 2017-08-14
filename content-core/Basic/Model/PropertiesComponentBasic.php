<?php

namespace Zrcms\ContentCore\Basic\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesComponentBasic extends PropertiesComponent
{
    const COMPONENT_CLASS = 'componentClass';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::COMPONENT_CONFIG_READER => '',
            self::COMPONENT_CLASS => '',
        ];
}
