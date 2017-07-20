<?php

namespace Zrcms\Core\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Core\Block\Model\BlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return BlockVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
