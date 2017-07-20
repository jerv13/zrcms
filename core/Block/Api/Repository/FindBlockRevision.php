<?php

namespace Zrcms\Core\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockRevision extends FindContentRevision
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return BlockRevision|ContentRevision|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
