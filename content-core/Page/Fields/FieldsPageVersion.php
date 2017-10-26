<?php

namespace Zrcms\ContentCore\Page\Fields;

use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPageVersion extends FieldsPage
{
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
                'name' => self::CONTAINER_DATA,
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
                'name' => self::RENDER_TAGS_GETTER,
                'type' => 'zrcms-service',
                'label' => 'Render Tags Getter (GetRenderTags)',
                'required' => false,
                'default' => self::DEFAULT_RENDER_TAGS_GETTER,
                'options' => [],
            ],
        ];
}
