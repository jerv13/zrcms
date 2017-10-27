<?php

namespace Zrcms\ContentCore\Page\Fields;

use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPage extends FieldsContainer
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';
    const LAYOUT = 'layout';
    const CONTAINERS_DATA = 'containersData';
    const PRE_RENDERED_HTML = 'html';

    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    /**
     * @deprecated
     */
    const RENDERER = 'renderer';

    const DEFAULT_RENDER_TAGS_GETTER = 'blocks';
    const DEFAULT_RENDERER = 'rows';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
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
                'name' => self::CONTAINERS_DATA,
                'type' => 'array',
                'label' => 'Container Data',
                'required' => true,
                'default' => [
                    Page::DEFAULT_CONTAINER_NAME => [
                        FieldsContainer::BLOCK_VERSIONS => [],
                    ],
                ],
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
            [
                'name' => self::RENDER_TAGS_GETTER,
                'type' => 'zrcms-service',
                'label' => 'Render Tags Getter (GetRenderTags)',
                'required' => false,
                'default' => self::DEFAULT_RENDER_TAGS_GETTER,
                'options' => [],
            ],
        ];
}
