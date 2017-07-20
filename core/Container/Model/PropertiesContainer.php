<?php

namespace Zrcms\Core\Container\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesContainer extends PropertiesContent
{
    const RENDER_DATA_GETTER = 'renderDataGetter';
    const RENDERER = 'renderer';
    const RENDER_TAG = 'container';
}