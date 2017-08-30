<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesCmsResourcePublishHistory extends PropertiesCmsResource
{
    const ACTION = 'action';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION_ID => '',
            self::PUBLISHED => true,
            self::ACTION => '',
        ];
}
