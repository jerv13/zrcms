<?php

namespace Zrcms\ContentCore\Page\Fields;

use Zrcms\ContentCore\Container\Fields\FieldsContainer;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPage extends FieldsContainer
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';
    const LAYOUT = 'layout';
    const PRE_RENDERED_HTML = 'html';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::RENDER_TAGS_GETTER,
                'type' => 'zrcms-service',
                'label' => 'Render Tags Getter (GetRenderTags)',
                'required' => false,
                'default' => 'blocks',
                'options' => [],
            ],
            [
                'name' => self::RENDERER,
                'type' => 'zrcms-service',
                'label' => 'Renderer',
                'required' => false,
                'default' => 'rows',
                'options' => [],
            ],
            [
                'name' => self::BLOCK_VERSIONS,
                'type' => 'array',
                'label' => 'Block Versions',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::HTML_NAME,
                'type' => 'string',
                'label' => 'Name for page-container tag',
                'required' => true,
                'default' => self::DEFAULT_HTML_NAME,
                'options' => [],
            ],
            [
                'name' => self::TITLE,
                'type' => 'text',
                'label' => 'Title',
                'required' => false,
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
            [
                'name' => self::KEYWORDS,
                'type' => 'text',
                'label' => 'Keywords',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::LAYOUT,
                'type' => 'text',
                'label' => 'Layout',
                'required' => false,
                'default' => 'primary',
                'options' => [],
            ],
            [
                'name' => self::PRE_RENDERED_HTML,
                'type' => 'text',
                'label' => 'Pre-rendered HTML',
                'required' => false,
                'default' => null,
                'options' => [],
            ],
        ];
}
