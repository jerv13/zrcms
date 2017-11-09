<?php

namespace Zrcms\ContentCore\Container\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsContainerVersion extends FieldsContainer
{
    const SITE_CMS_RESOURCE_ID = 'siteCmsResourceId';
    const PATH = 'path';

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
                'default' => self::DEFAULT_RENDER_TAGS_GETTER,
                'options' => [],
            ],
            [
                'name' => self::RENDERER,
                'type' => 'zrcms-service',
                'label' => 'Renderer',
                'required' => false,
                'default' => self::DEFAULT_RENDERER,
                'options' => [],
            ],
            [
                'name' => self::BLOCK_VERSIONS,
                'type' => 'array',
                'label' => 'Block Versions',
                'required' => false,
                'default' => self::DEFAULT_BLOCK_VERSIONS,
                'options' => [],
            ],
            [
                'name' => self::SITE_CMS_RESOURCE_ID,
                'type' => 'id',
                'label' => 'Site CmsResourceId',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::PATH,
                'type' => 'text',
                'label' => 'Path Identifier',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
        ];
}
