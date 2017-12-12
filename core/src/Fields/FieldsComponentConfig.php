<?php

namespace Zrcms\Core\Fields;

use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\Trackable;
use Zrcms\Core\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponentConfig extends FieldsAbstract implements Fields
{
    const TYPE = 'type';
    const NAME = 'name';
    const CONFIG_URI = 'configUri';
    const MODULE_DIRECTORY = 'moduleDirectory';
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
    const CREATED_DATE = TrackableProperties::CREATED_DATE;
    const COMPONENT_CONFIG_READER = FieldsComponent::COMPONENT_CONFIG_READER;
    const COMPONENT_CLASS = FieldsComponent::COMPONENT_CLASS;

    const DEFAULT_TYPE = 'basic';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::TYPE,
                'type' => 'text',
                'label' => 'Component Type',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::NAME,
                'type' => 'text',
                'label' => 'Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CONFIG_URI,
                'type' => 'text',
                'label' => 'Config Location (usually a path or application config key)',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::MODULE_DIRECTORY,
                'type' => 'text',
                'label' => 'Module Directory (module directory for component files)',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CREATED_BY_USER_ID,
                'type' => 'zrcms-service',
                'label' => 'Created By User ID',
                'required' => false,
                'default' => Trackable::UNKNOWN_USER_ID,
                'options' => [],
            ],
            [
                'name' => self::CREATED_REASON,
                'type' => 'class',
                'label' => 'Component Class',
                'required' => false,
                'default' => Trackable::UNKNOWN_REASON,
                'options' => [],
            ],
            [
                'name' => self::CREATED_DATE,
                'type' => 'string',
                'label' => 'Created Date',
                'required' => false,
                'default' => null, // This should be and empty string, but might cause issues
                'options' => [],
            ],
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
        ];
}
