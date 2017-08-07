<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewLayoutTags\Model;

use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewLayoutTagsGetterComponentRegistryFields extends ComponentRegistryFields
{
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::COMPONENT_CONFIG_READER => '',
        ];
}
