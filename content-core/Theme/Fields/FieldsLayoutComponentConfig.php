<?php

namespace Zrcms\ContentCore\Theme\Fields;

use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutComponent;
use Zrcms\ContentCore\Theme\Model\LayoutComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsLayoutComponentConfig extends FieldsComponentConfig
{
    const TEMPLATE_FILE = 'templateFile';
    const RENDERER = FieldsLayoutComponent::RENDERER;
    const RENDER_TAGS_GETTER = FieldsLayoutComponent::RENDER_TAGS_GETTER;
    const RENDER_TAG_NAME_PARSER = FieldsLayoutComponent::RENDER_TAG_NAME_PARSER;

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
                'default' => LayoutComponentBasic::class,
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
                'name' => self::RENDER_TAGS_GETTER,
                'type' => 'zrcms-service',
                'label' => 'Render Tags Getter (GetRenderTags)',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::RENDER_TAG_NAME_PARSER,
                'type' => 'zrcms-service',
                'label' => 'Tag Name Parser',
                'required' => false,
                'default' => 'mustache',
                'options' => [],
            ],
        ];
}
