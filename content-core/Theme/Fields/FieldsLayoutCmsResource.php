<?php

namespace Zrcms\ContentCore\Theme\Fields;

use Zrcms\Content\Fields\FieldsCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsLayoutCmsResource extends FieldsCmsResource
{
    const THEME_NAME = 'themeName';
    const NAME = 'name';

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
                'name' => self::NAME,
                'type' => 'text',
                'label' => 'Layout Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
        ];
}
