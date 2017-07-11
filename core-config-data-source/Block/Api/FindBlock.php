<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlock implements \Zrcms\Core\Block\Api\FindBlock
{
    /**
     * @param string   $name
     * @param array $options
     *
     * @return Block|null
     */
    public function __invoke(
        $name,
        array $options = []
    ) {

    }
}
