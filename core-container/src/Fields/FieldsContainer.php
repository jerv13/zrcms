<?php

namespace Zrcms\CoreContainer\Fields;

use Zrcms\Core\Fields\FieldsContent;
use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsContainer extends FieldsContent implements Fields
{
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDERER = 'renderer';
    const BLOCK_VERSIONS = 'blockVersions';

    const DEFAULT_RENDER_TAGS_GETTER = 'blocks';
    const DEFAULT_RENDERER = 'rows';
    const DEFAULT_BLOCK_VERSIONS = [];

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
        ];
}
