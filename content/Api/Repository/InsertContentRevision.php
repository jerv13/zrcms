<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\ContentRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertContentRevision
{
    /**
     * @param ContentRevision $contentRevision
     * @param array           $options
     *
     * @return ContentRevision
     */
    public function __invoke(
        ContentRevision $contentRevision,
        array $options = []
    ): ContentRevision;
}
