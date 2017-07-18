<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockInstanceProperties
{
    // required
    const BLOCK_NAME = 'blockName';
    const CONFIG = 'config';

    // client layout required
    const LAYOUT_PROPERTIES = 'layoutProperties';
    const LAYOUT_PROPERTIES_RENDER_ORDER = 'renderOrder';
    const LAYOUT_PROPERTIES_ROW_NUMBER = 'rowNumber';
    const LAYOUT_PROPERTIES_COLUMN_CLASS = 'columnClass';

    // render data properties
    const RENDER_DATA_ID = 'id';
    const RENDER_DATA_CONFIG = 'config';
    const RENDER_DATA_DATA = 'data';
}
