<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponent;
use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Block\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockComponent extends FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return BlockComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}
