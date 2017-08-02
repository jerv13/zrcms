<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Model;

use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockComponentRegistryFields extends ComponentRegistryFields
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
