<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent
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
    ) {
        return parent::__invoke(
            $name,
            $options
        );
    }
}
