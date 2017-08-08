<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesViewLayoutTagsComponent extends PropertiesComponent
{
    const RENDER_TAGS_GETTER = 'renderTagsGetter';

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
