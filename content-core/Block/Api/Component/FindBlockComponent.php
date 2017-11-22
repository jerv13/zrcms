<?php

namespace Zrcms\ContentCore\Block\Api\Component;

use Zrcms\Content\Api\Component\FindComponent;
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
