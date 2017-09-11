<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContainerCmsResource extends PropertiesCmsResource
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';
    const PATH = 'path';

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
            self::SITE_CMS_RESOURCE_ID => '',
            self::PATH => ''
        ];
}
