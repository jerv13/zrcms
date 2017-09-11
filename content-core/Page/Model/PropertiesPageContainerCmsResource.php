<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\ContentCore\Container\Model\PropertiesContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesPageContainerCmsResource
    extends PropertiesContainerCmsResource
{
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
