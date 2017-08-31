<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesCmsResourcePublishHistory extends PropertiesCmsResource
{
    const CMS_RESOURCE_ID = 'cmsResourceId';
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
            self::CMS_RESOURCE_ID => '',
            self::ACTION => '',
            self::PUBLISHED => true,
            self::ACTION => '',
        ];
}
