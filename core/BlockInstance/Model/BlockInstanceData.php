<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockInstanceData extends BlockInstance
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data);
}
