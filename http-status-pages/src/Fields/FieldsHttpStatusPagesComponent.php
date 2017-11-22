<?php

namespace Zrcms\HttpStatusPages\Fields;

use Zrcms\Content\Model\ComponentBasic;
use Zrcms\ContentCore\Basic\Fields\FieldsComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsHttpStatusPagesComponent extends FieldsComponentBasic
{
    const STATUS_TO_SITE_PATH_PROPERTY = 'status-to-site-page-path-property-map';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::COMPONENT_CONFIG_READER,
                'type' => 'zrcms-service',
                'label' => 'Component Config Reader',
                'required' => false,
                'default' => 'json',
                'options' => [],
            ],
            [
                'name' => self::COMPONENT_CLASS,
                'type' => 'class',
                'label' => 'Component Class',
                'required' => false,
                'default' => ComponentBasic::class,
                'options' => [],
            ],
            [
                'name' => self::STATUS_TO_SITE_PATH_PROPERTY,
                'type' => 'array',
                'label' => 'Map of HTTP status to the path and a type',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
        ];

}
