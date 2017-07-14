<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockInstanceProperties
{
    const CONTAINER_ID = 'containerId';
    const BLOCK_NAME = 'blockName';
    const CONFIG = 'config';

    const LAYOUT_PROPERTIES = 'layoutProperties';
    const LAYOUT_PROPERTIES_RENDER_ORDER = 'renderOrder';
    const LAYOUT_PROPERTIES_ROW_NUMBER = 'rowNumber';
    const LAYOUT_PROPERTIES_COLUMN_CLASS = 'columnClass';

    const RENDER_ID = 'id';
    const RENDER_CONFIG = 'config';
    const RENDER_DATA = 'data';
}
