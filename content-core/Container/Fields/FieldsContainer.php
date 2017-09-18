<?php

namespace Zrcms\ContentCore\Container\Fields;

use Zrcms\Content\Fields\Fields;
use Zrcms\Content\Fields\FieldsContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsContainer extends FieldsContent implements Fields
{
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDERER = 'renderer';
    const BLOCK_VERSIONS = 'blockVersions';

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
        ];
}
