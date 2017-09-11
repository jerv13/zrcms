<?php

namespace Zrcms\ContentCore\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesPageTemplateCmsResource
    extends PropertiesPageContainerCmsResource
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
            self::SITE_CMS_RESOURCE_ID => '',
            self::PATH => ''
        ];
}
