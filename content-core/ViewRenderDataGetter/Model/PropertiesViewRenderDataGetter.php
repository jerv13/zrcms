<?php

namespace Zrcms\ContentCore\ViewRenderDataGetter\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesViewRenderDataGetter extends PropertiesComponent
{
    const RENDER_DATA_GETTER = 'renderDataGetter';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::RENDER_DATA_GETTER => '',
        ];
}
