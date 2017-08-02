<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesComponent extends PropertiesSettableAbstract implements Properties
{
    const NAME = 'name';
    const LOCATION = 'location';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::LOCATION => '',
        ];
}
