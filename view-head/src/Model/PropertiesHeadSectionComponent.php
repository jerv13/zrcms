<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\ContentCore\View\Fields\FieldsViewLayoutTagsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesHeadSectionComponent extends FieldsViewLayoutTagsComponent
{
    const TAG = 'tag';
    const SECTIONS = 'sections';
    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::RENDER_TAGS_GETTER => '',
        ];
}
