<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesComponent extends PropertiesSettableAbstract implements Properties
{
    const NAME = 'name';
    const CONFIG_LOCATION = 'configLocation';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
        ];
}
