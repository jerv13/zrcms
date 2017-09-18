<?php

namespace Zrcms\ContentCore\View\Fields;

use Zrcms\Content\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsViewLayoutTagsComponent extends FieldsComponent
{
    const RENDER_TAGS_GETTER = 'renderTagsGetter';

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
                'default' => '',
                'options' => [],
            ],
        ];
}
