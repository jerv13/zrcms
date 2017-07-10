<?php

namespace Zrcms\Core\BlockInstance\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockInstanceDataAbstract extends BlockInstanceAbstract implements BlockInstanceData
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
