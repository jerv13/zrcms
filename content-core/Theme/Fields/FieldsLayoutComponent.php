<?php

namespace Zrcms\ContentCore\Theme\Fields;

use Zrcms\Content\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsLayoutComponent extends FieldsComponent
{
    const THEME_NAME = 'themeName';
    const HTML = 'html';
    const RENDERER = 'renderer';
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDER_TAG_NAME_PARSER = 'renderTagNameParser';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::THEME_NAME,
                'type' => 'text',
                'label' => 'Theme Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::HTML,
                'type' => 'text',
                'label' => 'Template HTML',
                'required' => true,
                'default' => '',
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
