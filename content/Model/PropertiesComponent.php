<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesComponent extends PropertiesSettableAbstract implements Properties
{
    /** @deprecated */
    const NAME = 'name';
    /** @deprecated */
    const CONFIG_LOCATION = 'configLocation';

    const COMPONENT_CONFIG_READER = 'componentConfigReader';
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
