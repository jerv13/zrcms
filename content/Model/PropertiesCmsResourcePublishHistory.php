<?php

namespace Zrcms\Content\Model;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesCmsResourcePublishHistory
{
    /** @deprecated */
    const ID = 'id';
    /** @deprecated */
    const CONTENT_VERSION = 'contentVersion';
    /** @deprecated */
    const PUBLISHED = 'published';
    /** @deprecated */
    const CMS_RESOURCE_ID = 'cmsResourceId';
    /** @deprecated */
    const ACTION = 'action';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION => null,
            self::CMS_RESOURCE_ID => '',
            self::ACTION => '',
            self::PUBLISHED => true,
            self::ACTION => '',
        ];
}
