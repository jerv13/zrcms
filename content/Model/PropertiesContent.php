<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContent extends PropertiesSettableAbstract implements Properties
{
    const ID = 'id';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
        ];
}
