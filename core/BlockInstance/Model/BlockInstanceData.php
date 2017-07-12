<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @deprecated Handled by GetBlockInstanceRenderData
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockInstanceData extends BlockInstance
{

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @param string $blockName
     * @param null   $default
     *
     * @return mixed
     */
    public function getDataValue(string $blockName, $default = null);
}
