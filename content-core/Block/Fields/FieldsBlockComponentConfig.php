<?php

namespace Zrcms\ContentCore\Block\Fields;

use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsBlockComponentConfig extends FieldsComponentConfig
{
    const DEFAULT_CONFIG = FieldsBlockComponent::DEFAULT_CONFIG;
    const CACHEABLE = FieldsBlockComponent::CACHEABLE;

    const RENDERER = FieldsBlockComponent::RENDERER;
    const DATA_PROVIDER = FieldsBlockComponent::DATA_PROVIDER;
    const FIELDS = FieldsBlockComponent::FIELDS;
    const TEMPLATE_FILE = FieldsBlockComponent::TEMPLATE_FILE;

    // client only
    const ICON = FieldsBlockComponent::ICON;
    const EDITOR = FieldsBlockComponent::EDITOR;
    const CATEGORY = FieldsBlockComponent::CATEGORY;
    const LABEL = FieldsBlockComponent::LABEL;
    const DESCRIPTION = FieldsBlockComponent::DESCRIPTION;

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
                'default' => BlockComponentBasic::class,
                'options' => [],
            ],
            [
                'name' => self::DEFAULT_CONFIG,
                'type' => 'array',
                'label' => 'Default Config',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::CACHEABLE,
                'type' => 'bool',
                'label' => 'Cachable',
                'required' => false,
                'default' => false,
                'options' => [],
            ],
            [
                'name' => self::RENDERER,
                'type' => 'zrcms-service',
                'label' => 'Renderer',
                'required' => false,
                'default' => 'mustache',
                'options' => [],
            ],
            [
                'name' => self::DATA_PROVIDER,
                'type' => 'zrcms-service',
                'label' => 'Data Provider',
                'required' => false,
                'default' => 'noop',
                'options' => [],
            ],
            [
                'name' => self::FIELDS,
                'type' => 'fields',
                'label' => 'Fields',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::TEMPLATE_FILE,
                'type' => 'string',
                'label' => 'Template File',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::ICON,
                'type' => 'text',
                'label' => 'Icon Path',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::EDITOR,
                'type' => 'text',
                'label' => 'Client Editor',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CATEGORY,
                'type' => 'text',
                'label' => 'Category',
                'required' => false,
                'default' => 'General',
                'options' => [],
            ],
            [
                'name' => self::LABEL,
                'type' => 'text',
                'label' => 'Label',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::DESCRIPTION,
                'type' => 'text',
                'label' => 'Description',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
        ];
}
