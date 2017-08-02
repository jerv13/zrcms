<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContainer extends PropertiesContent
{
    const RENDER_DATA_GETTER = 'renderDataGetter';
    const RENDERER = 'renderer';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::RENDER_DATA_GETTER => '',
            self::RENDERER => '',
        ];
}
