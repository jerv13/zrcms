<?php

namespace Zrcms\HttpRedirect\Redirect\Model;

use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesRedirectCmsResource extends PropertiesCmsResource
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTENT_VERSION_ID => '',
            self::SITE_CMS_RESOURCE_ID => '',
        ];
}
