<?php

namespace Zrcms\HttpExpressive1\Model;

use Zrcms\ContentCore\Basic\Model\PropertiesComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesHttpExpressiveComponent extends PropertiesComponentBasic
{
    const STATUS_TO_SITE_PATH_PROPERTY = 'status-to-site-page-path-property-map';

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
            self::COMPONENT_CLASS => '',
            self::STATUS_TO_SITE_PATH_PROPERTY => [],
        ];
}
