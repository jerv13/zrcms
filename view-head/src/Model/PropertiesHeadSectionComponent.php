<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\ContentCore\View\Model\PropertiesViewLayoutTagsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesHeadSectionComponent extends PropertiesViewLayoutTagsComponent
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
