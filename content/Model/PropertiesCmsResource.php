<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesCmsResource extends PropertiesSettableAbstract implements Properties
{
    const ID = 'id';
    const CONTENT_VERSION = 'contentVersion';
    const PUBLISHED = 'published';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION => null,
            self::PUBLISHED => true,
        ];
}
